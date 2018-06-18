<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 18/06/18
 * Time: 12:10
 */

namespace Tests\Framework;

use App\Framework\Upload;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Class UploadTest
 * @package Tests\Framework
 */
class UploadTest extends TestCase
{

    /**
     * @var Upload
     */
    private $upload;

    /**
     *
     */
    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->upload = new Upload('tests');
    }

    public function tearDown()/* The :void return type declaration that should be here would cause a BC issue */
    {
        if (file_exists('tests/demo.jpg')) {
            unlink('tests/demo.jpg');
        }
    }

    /**
     *
     */
    public function testUpload(): void
    {
        $uploadedFile = $this->getMockBuilder(UploadedFileInterface::class)->getMock();

        $uploadedFile->expects($this->any())
            ->method('getError')
            ->willReturn(UPLOAD_ERR_OK);

        $uploadedFile->expects($this->any())
            ->method('getClientFilename')
            ->willReturn('demo.jpg');

        $uploadedFile->expects($this->once())
            ->method('moveTo')
            ->with($this->equalTo('tests/demo.jpg'));

        $this->assertEquals('demo.jpg', $this->upload->upload($uploadedFile));
    }

    public function testDontMoveIfFileNotUploaded(): void
    {
        $uploadedFile = $this->getMockBuilder(UploadedFileInterface::class)->getMock();

        $uploadedFile->expects($this->any())
            ->method('getError')
            ->willReturn(UPLOAD_ERR_CANT_WRITE);

        $uploadedFile->expects($this->any())
            ->method('getClientFilename')
            ->willReturn('demo.jpg');

        $uploadedFile->expects($this->never())
            ->method('moveTo')
            ->with($this->equalTo('tests/demo.jpg'));

        $this->assertNull($this->upload->upload($uploadedFile));
    }

    /**
     *
     */
    public function testUploadWithExistingFile(): void
    {
        $uploadedFile = $this->getMockBuilder(UploadedFileInterface::class)->getMock();

        $uploadedFile->expects($this->any())
            ->method('getError')
            ->willReturn(UPLOAD_ERR_OK);

        $uploadedFile->expects($this->any())
            ->method('getClientFilename')
            ->willReturn('demo.jpg');

        touch('tests/demo.jpg');

        $uploadedFile->expects($this->once())
            ->method('moveTo')
            ->with($this->equalTo('tests/demo_copy.jpg'));

        $this->assertEquals('demo_copy.jpg', $this->upload->upload($uploadedFile));
    }

}