<?php
namespace AppBundle\Listener;

use Oneup\UploaderBundle\Event\PostPersistEvent;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Product;
use AppBundle\Entity\Photo;
use Imagine\Image\ImageInterface;

class UploadListener
{
    /**
     * @var ObjectManager
     */
    protected $manager;

    protected $webRoot;

    protected $width;
    protected $height;

    public function __construct(ObjectManager $manager, $rootDir, $width, $height)
    {
        $this->manager = $manager;
        $this->webRoot = $rootDir.'/../web';
        $this->width = $width;
        $this->height = $height;
    }

    public function onUpload(PostPersistEvent $event)
    {
        $file = $event->getFile();
        $response = $event->getResponse();
        $request = $event->getRequest();
        $productId = $request->get('product');


        $imagine = new \Imagine\Gd\Imagine();
        $size = new \Imagine\Image\Box($this->width, $this->height);

        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
        $path = pathinfo($file->getPathName());
        $tmbName = $path['dirname'].'/'.$path['filename'].'.tmb.'.$path['extension'];


        $imagine->open($file->getPathName())
            ->thumbnail($size, $mode)
            ->save($tmbName, [
                'jpeg_quality' => 77,
                'resampling-filter' => ImageInterface::FILTER_QUADRATIC,
            ]);

        $object = new Photo();
        $object->setImageName($this->getWebPath($file->getPathName()));
        $object->setTmbName($this->getWebPath($tmbName));

        if ($productId) {
            $product = $this->manager->getRepository('AppBundle:Product')->find($productId);
            $product->addPhoto($object);
            $this->manager->persist($product);
        }

        $this->manager->persist($object);
        $this->manager->flush();

        $response['files'] = [
            [
                'url' => $object->getImageName(),
                'thumbnailUrl' => $object->getTmbName(),
                'id' => $object->getId(),
            ],
        ];


    }

    private function getWebPath($path)
    {

        return str_replace('\\', '/', str_replace($this->webRoot, '', $path));
    }
}