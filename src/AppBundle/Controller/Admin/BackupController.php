<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\AppSetting;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Route("/admin/backup")
 */
class BackupController extends Controller
{
    public static $defaultBackupSettings = [
        ['system_name' => 'backup_database_user', 'display_name' => 'Database backup user', 'group_name' => 'backup', 'value' => 'pguser'],
        ['system_name' => 'backup_database_pass', 'display_name' => 'Database backup user password', 'group_name' => 'backup', 'value' => 'pgpassword'],
        ['system_name' => 'backup_database_host', 'display_name' => 'Database host', 'group_name' => 'backup', 'value' => 'localhost'],
        ['system_name' => 'backup_database_name', 'display_name' => 'Database name', 'group_name' => 'backup', 'value' => 'prossimo'],
        ['system_name' => 'backup_catalog_path', 'display_name' => 'Backup files catalog path', 'group_name' => 'backup', 'value' => '/var/backup'],
        ['system_name' => 'backup_filename_format', 'display_name' => 'Backup filename format', 'group_name' => 'backup', 'value' => '{{dbname}}_{{date}}.sql.backup']
    ];

    /**
     * @Route("/", name="admin_backup")
     * @Method("GET")
     * @Template("Admin/Backup/index.html.twig")
     */
    public function indexAction()
    {
        $settings = $this->getBackupSettings();
        $backupCatalog = $settings['backup_catalog_path'];
        $backupFilenameFormat = $settings['backup_filename_format'];

        // TODO: Add button to send backup file to GDrive using API

        $backupFiles = $this->getAllBackupFiles($backupCatalog, $backupFilenameFormat);

        return [
            'backup_catalog_path' => $backupCatalog,
            'backup_files' => $backupFiles
        ];
    }

    /**
     * @Route("/process", name="admin_backup_process")
     * @Method("GET")
     * @Template("Admin/Backup/process.html.twig")
     */
    public function backupProcessAction() {
        // TODO: Execute backup command and output result as Flash
        $settings = $this->getBackupSettings();
        $result = $this->executeSystemBackupCommand(
            $settings['backup_database_user'],
            $settings['backup_database_pass'],
            $settings['backup_database_host'],
            $settings['backup_database_name'],
            $settings['backup_catalog_path'],
            $settings['backup_filename_format']
        );

        return $this->redirectToRoute('admin_backup');
    }

    /**
     * @Route("/settings", name="admin_backup_settings")
     * @Method({"GET", "POST"})
     * @Template("Admin/Backup/settings.html.twig")
     */
    public function backupSettingsAction(Request $request) {
        $settingsData = $this->getBackupSettings();
        $form = $this->createBackupSettingsForm($settingsData);

        if ($request->isMethod('post')) {
            $form->submit($request);

            if ($form->isValid()) {
                $this->saveBackupSettings($form->getData());
            }
        }

        return ['form' => $form->createView()];
    }

    private function getBackupSettings() {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:AppSetting');

        $settingsDataArray = [];
        foreach (self::$defaultBackupSettings as $setting) {
            $value = $repo->findOneBy(['system_name' => $setting['system_name'], 'group_name' => $setting['group_name']]);
            if (!$value instanceof AppSetting) {
                $value = $repo->setAppSetting(
                    $setting['system_name'],
                    $setting['value'],
                    $setting['display_name'],
                    $setting['group_name']
                );
            }
            $settingsDataArray[$value->getSystemName()] = $value->getValue();
        }

        return $settingsDataArray;
    }

    private function createBackupSettingsForm($settingsData) {
        $form = $this->createFormBuilder($settingsData)
            ->add('backup_database_user', 'text', [
                'label'       => 'Database backup user',
                'required'    => true,
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('backup_database_pass', 'text', [
                'label'       => 'Database backup user password',
                'required'    => true,
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('backup_database_host', 'text', [
                'label'       => 'Database host',
                'required'    => true,
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('backup_database_name', 'text', [
                'label'       => 'Database name',
                'required'    => true,
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('backup_catalog_path', 'text', [
                'label'       => 'Backup catalog path',
                'required'    => true,
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('backup_filename_format', 'text', [
                'label'       => 'Backup filename',
                'required'    => true,
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('save', 'submit', [
                'label' => 'Save backup settings',
            ])
            ->getForm();
        return $form;
    }

    private function getAllBackupFiles($backupCatalogPath, $backupFilenameFormat) {
        // TODO: Parse FilenameFormat and use it
        $files = array();
        foreach (glob($backupCatalogPath . "prossimo_*.sql.backup") as $file) {
            $fileInfo = pathinfo($file);
            $fileInfo['filesize'] = filesize($file);
            $files[$file] = $fileInfo;
        }
        krsort($files);
        return $files;
    }

    /**
     * @param  array $backupSettings
     * @throws \Doctrine\DBAL\DBALException
     */
    private function saveBackupSettings($backupSettings)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $em->getConnection()->executeQuery("DELETE FROM app_settings WHERE group_name = 'backup';");

        foreach (static::$defaultBackupSettings as $default) {
            foreach ($backupSettings as $name => $value) {
                if ($default['system_name'] === $name) {
                    $em->persist(
                        (new AppSetting())
                            ->setSystemName($name)
                            ->setDisplayName($default['display_name'])
                            ->setGroupName($default['group_name'])
                            ->setValue($value)
                    );
                }
            }
        }

        $em->flush();
        $this->addFlash('alert alert-success', 'Backup Settings saved');
    }

    private function executeSystemBackupCommand($dbuser, $dbpass, $dbhost, $dbname, $backupCatalogPath, $backupFilenameFormat) {
        // TODO: Parse FilenameFormat and use it
        $backupDatetime = new \DateTime();
        $backupFilename = $dbname . '_' . $backupDatetime->format('YmdHis') .'.sql.backup';
        $backupPath = $backupCatalogPath . $backupFilename;

        $commandParts = [];
        $commandParts[0] = "export PGUSER=" . $dbuser;
        $commandParts[1] = "export PGPASSWORD=" . $dbpass;
        $commandParts[2] = "pg_dump -h " . $dbhost . " -d " . $dbname . " -Co > " . $backupPath;
        $commandParts[3] = "unset PGPASSWORD";
        $commandParts[4] = "unset PGUSER";

        $command = implode(" && ", $commandParts);
        $output = '';
        $result = exec($command, $output);
        // $result = exec("export PGPASSWORD=mypassword && export PGUSER=myuser && pg_dump -h yourremotehost -d db_name -Co > /tmp/db_name_backup.sql && unset PGPASSWORD && unset PGUSER");
        return $result;
    }
}
