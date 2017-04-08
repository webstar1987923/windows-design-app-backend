<?php

namespace AppBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\BinaryFile;
use AppBundle\Entity\Project;

/**
 * Class ProjectFileManager
 */
class ProjectFileManager
{
    /** @var FilesManager */
    protected $filesManager;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @param FilesManager  $filesManager
     * @param ObjectManager $objectManager
     */
    public function __construct(FilesManager $filesManager, ObjectManager $objectManager)
    {
        $this->filesManager = $filesManager;
        $this->objectManager = $objectManager;
    }

    /**
     * @param Project $project
     * @param array   $fileUuids
     */
    public function updateProjectFiles(Project $project, array $fileUuids = [])
    {
        if (!$project->getBinaryFiles()->isEmpty() && empty($fileUuids)) {
            // if we didn't pass any UUID's then we need to remove all files
            // for this project
            $this->deleteAllProjectFiles($project);
            $this->objectManager->flush();
            // nothing left to do. get out
            return;
        }

        // if we're still here, we either need to remove existing files,
        // or add new ones.
        // so let's figure that out
        $remFiles = iterator_to_array($this->getFilesToRemove($project, $fileUuids));
        $fileUuids = $this->filterOutExistingFiles($project, $fileUuids);

        if (!empty($fileUuids)) {
            foreach ($fileUuids as $uuid) {
                $this->filesManager->linkTempFileToProject($uuid, $project);
            }
        }

        if (!empty($remFiles)) {
            $this->deleteProjectFiles($project, $remFiles);
        }

        $this->objectManager->flush();
    }

    /**
     * @param Project $project
     * @param array   $fileUuids
     */
    private function deleteProjectFiles(Project $project, array $fileUuids = [])
    {
        if (!$project->getBinaryFiles()->isEmpty() && !empty($fileUuids)) {
            /** @var BinaryFile $file */
            foreach ($project->getBinaryFiles() as $file) {
                foreach ($fileUuids as $uuid) {
                    if ($file->getUuid() == $uuid) {
                        $this->filesManager->unlinkProjectFile($file, $project);
                    }
                }
            }
        }
    }

    /**
     * @param Project $project
     */
    private function deleteAllProjectFiles(Project $project)
    {
        if (!$project->getBinaryFiles()->isEmpty()) {
            $fileUuids = array_map(function(BinaryFile $file){
                return $file->getUuid();
            }, $project->getBinaryFiles()->toArray());

            $this->deleteProjectFiles($project, $fileUuids);
        }
    }

    /**
     * @param  Project $project
     * @param  array   $fileUuids
     * @return \Generator
     */
    private function getFilesToRemove(Project $project, array $fileUuids = [])
    {
        if (!empty($fileUuids)) {
            foreach ($project->getBinaryFiles() as $file) {
                if (!in_array($file->getUuid(), $fileUuids)) {
                    yield $file->getUuid();
                }
            }
        }
    }

    /**
     * @param  Project $project
     * @param  array   $fileUuids
     * @return array
     */
    private function filterOutExistingFiles(Project $project, array $fileUuids = [])
    {
        if (empty($fileUuids)) {
            return [];
        }

        return array_diff(
            $fileUuids,
            array_intersect(
                $fileUuids,
                array_map(
                    function(BinaryFile $f){
                        return $f->getUuid();
                    },
                    $project->getBinaryFiles()->toArray()
                )
            )
        );
    }
}
