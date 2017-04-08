<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Lib\FetchRemote;
use AppBundle\Tests\Controller\Rest\RestTestCase;
use Symfony\Component\HttpFoundation\Response;

class PdfControllerTest extends RestTestCase
{
    public function testPdfDirectoryExists() {
        $container = $this->client->getContainer();
        $pdfDir = $container->getParameter('pdf_data_path');
        $this->assertFileExists($pdfDir);
    }

    public function testSplitAndMergeInvalidRequest()
    {
        $client = self::createAuthenticatedClient();

        // Test invalid URL
        $client->request('POST', '/api/pdf/splitmerge', [
            'url' => 'some invalid url',
            'pages' => '1,3,20'
        ]);
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());

        // Test invalid pages
        $client->request('POST', '/api/pdf/splitmerge', [
            'url' => 'http://www.ti.com/lit/ds/symlink/ne555.pdf',
            'pages' => '1,,3'
        ]);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider extractTableInvalidData
     */
    public function testExtractTableInvalidRequestAction($data)
    {
        $client = self::createAuthenticatedClient();
        $client->request('POST', '/api/pdf/exctracttable', $data);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function extractTableInvalidData()
    {
        $rawItems = [
            ['Some invalid url', 0, 2433,609,1569,585,6800],
            ['http://site.com/path/to/table.pdf', '', 2433,609,1569,585,6800],
            ['http://site.com/path/to/table.pdf', 0, 'a',609,1569,585,6800],
            ['http://site.com/path/to/table.pdf', 0, 2433,'b',1569,585,6800],
            ['http://site.com/path/to/table.pdf', 0, 2433,609,'c',585,6800],
            ['http://site.com/path/to/table.pdf', 0, 2433,609,1569,'d',6800],
            ['http://site.com/path/to/table.pdf', 0, 2433,609,1569,585,'e']
        ];

        $data = [];
        foreach ($rawItems as $rawItem) {
            $data[] = [[
                'url' => $rawItem[0],
                'page_number' => $rawItem[1],
                'x' => $rawItem[2],
                'y' => $rawItem[3],
                'w' => $rawItem[4],
                'h' => $rawItem[5],
                'pw' => $rawItem[6]
            ]];
        }
        return $data;
    }
    public function testSplitAndMergeAction()
    {
        $client = self::createAuthenticatedClient();


        $fr = $this->getMock(FetchRemote::class);
        $fr->expects($this->any())
            ->method("fetch")
            ->will($this->returnValue(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'PdfControllerTestDoc1.pdf')));
        $client->getContainer()->set('app.fetch_remote', $fr);

        $client->request('POST', '/api/pdf/splitmerge', [
            'url' => 'http://some.site.com/path/to/test.pdf',
            'pages' => '1,4-5'
        ]);

        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));

        $data = json_decode($response->getContent(), true);
        $this->assertEquals([
            'url' => '/data/pdf/test.pdf',
            'pages' => [
                '/data/pdf/test_1.jpg',
                '/data/pdf/test_4.jpg',
                '/data/pdf/test_5.jpg'
            ]
        ], $data);
    }

    public function testExtractTableAction()
    {

        $fr = $this->getMock(FetchRemote::class);
        $fr->expects($this->any())
            ->method("fetch")
            ->will($this->returnValue(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'PdfControllerTestDoc2.pdf')));

        $client = self::createAuthenticatedClient();
        $client->getContainer()->set('app.fetch_remote', $fr);

        $client->request('POST', '/api/pdf/exctracttable', [
            'url' => 'http://some.site.com/document.pdf',
            'page_number' => 0,
            'x' => 2433,
            'y' => 609,
            'w' => 1569,
            'h' => 585,
            'pw' => 6800
        ]);

        $response = $client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));

        $data = json_decode($response->getContent(), true);
        $expected = [
            [ 'DOOR SCHEDULE' ],
            [ 'NUMBER', 'FLOOR', 'QTY', 'WIDTH', 'HEIGHT', 'R/O', 'DESCRIPTION' ],
            [ 'D01', '1', '1', '30 "', '80 "', '32"X82 1/2"', 'HINGED-DOOR P04' ],
            [ 'D02', '1', '1', '30 "', '80 "', '32"X82 1/2"', '2 DR. BIFOLD-LOUVERED' ],
            [ 'D03', '1', '1', '36 "', '80 "', '38"X82 1/2"', 'POCKET-DOOR P04' ],
            [ 'D04', '1', '2', '36 "', '80 "', '38"X83"', 'EXT. HINGED-DOOR E21' ],
            [ 'D05', '1', '1', '96 "', '80 "', '98"X83"', 'EXT. SLIDER-DOOR F01' ],
            [ 'D06', '1', '1', '48 "', '80 "', '50"X82 1/2"', 'SLIDER-DOOR P04' ],
            [ 'D07', '1', '1', '192 "', '84 "', '194"X87"', 'GARAGE-GARAGE DOOR CHD05' ],
            [ 'D08', '2', '2', '32 "', '80 "', '34"X82 1/2"', 'POCKET-DOOR P04' ],
            [ 'D11', '2', '3', '32 "', '80 "', '34"X82 1/2"', 'HINGED-DOOR P04' ],
            [ 'D12', '2', '1', '30 "', '80 "', '32"X82 1/2"', 'HINGED-DOOR P04' ],
            [ 'D14', '2', '1', '36 "', '80 "', '38"X82 1/2"', '2 DR. BIFOLD-LOUVERED' ],
            [ 'D15', '2', '1', '72 "', '80 "', '74"X82 1/2"', 'SLIDER-DOOR P04' ]
        ];
        $this->assertEquals($expected, $data);

    }
}
