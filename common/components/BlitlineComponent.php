<?php
namespace  common\components;
/**
 * Created by PhpStorm.
 * User: dmitry
 */

use common\models\Files;
use Detail\Blitline\BlitlineClient;
use yii\helpers\Url;

class BlitlineComponent  extends  \yii\base\Component{

    public $apiKey ;

    public $s3region;
    public $defaultBucket;
//    public $site;

    const SIZESMAP = [
      '_big'=>2000,
      '_mid'=>800,
      '_thumb'=>300,
    ];

    public function upload($imageUrl,$relativeUrl, $modelId,  $sizes = ['_big' ,'_mid' ,'_thumb']){

        if (!$imageUrl ) {
            return false;
        }

        $image = new \SplFileInfo($imageUrl);
        $imageName = $image->getBasename();

        $config = [
            'application_id' => $this->apiKey,
            's3bucket' => $this->defaultBucket,
            's3region' => $this->s3region,
            'postback_url' => Url::to(['/api/site/upload-end','id'=>$modelId ], true)
        ];
        $blitline = BlitlineClient::factory($config);

        $jobBuilder = $blitline->getJobBuilder();
        $jobBuilder->setDefaultOption(
            'function.save',
            [
                's3_destination' => [
                    'bucket' => $config['s3bucket'],
                    'region' => $config['s3region'],
                ],
            ]
        );

        $jobs = [];
        foreach ($sizes as $size){


            $jobs[] = $jobBuilder->createFunction()
                ->setName($size == '_thumb' ? 'resize_to_fill' : 'resize_to_fit')
                ->setParams(
                    [
                        'width' => self::SIZESMAP[$size],
                        'height' => self::SIZESMAP[$size],
                        'only_shrink_larger' => true, // Don't upscale image
                    ]
                )
                ->setSaveOptions(
                    [
                        'image_identifier' => $imageName,
                        's3_destination' => [

                            'key' => str_replace('_master',$size, $relativeUrl) ,
                        ],
                        'quality'=>65
                    ]
                )->toArray();
        }



        $job = $jobBuilder
            ->createJob()
            ->setSource($imageUrl)
            ->setFunctions(
                $jobs
            )
        ;

        $job->setOption('postback_url' , Url::to(['/site/upload-end','id'=>$modelId ], true));

        if (isset($config['version'])) {
            $job->setVersion($config['version']);
        }

        $response = $blitline->submitJob($job);

//  "job_info":
// "trunc:
//{\"src\":\"https://communitya-mainstorage.s3.us-east-2.amazonaws.com/uploads/images/pz/xm/ha/5c8bf63497b67_master.jpg\",
//\"v\":\"1.22\",
//\"functions\":[{\"save\":{\"s3_destination\":{\"bucket\":\"communitya-mainstorage\",\"region\":\"us-east-2\",\"key\":\"uploads/images/pz/xm/ha/5c8bf63497b67_big.jpg\",\"bucket_as_domain\":true},\"image_identifier\":\"5c8bf63497b67_master.jpg\",\"quality\":65,\"save_profiles\":true,\"blitline_id\":\"7WEZZJX_kA7BXOJeqP5cF9w\"},\"name\":\"resize_to_fit\",\"params\":{\"width\":2000,\"height\":2000,\"only_shrink_larger\":true}},{\"save\":{\"s3_destination\":{\"bucket\":\"communitya-mainstorage\",\"region\":\"us-east-2\",\"key\":\"uploads/images/pz/xm/ha/5c8bf63497b67_mid.jpg\",\"bucket_as_domain\":true},\"image_identifier\":\"5c8bf63497b67_master.jpg\",\"quality\":65,\"save_profiles\":true,\"blitline_id\":\"6fgwv8HEg6cru8OL_R8zwpQ\"},\"name\":\"resize_to_fit\",\"params\":{\"width\":800,\"height\":800,\"only_shrink_larger\":true}},{\"save\":{\"s3_destination\":{\"bucket\":\"communitya-mainstorage\",\"region\":\"us-east-2\",\"key\":\"uploads/images/pz/xm/ha/5c8bf63497b67_thumb.jpg\",\"bucket_"
//        if ($response->hasErrors()) {
//            return $response->getErrors();
//        }
//        $waiting = $this->waitingJob($response->getJobId() );

        return $response;

    }




    function waitingJob($id){
        $url = "http://cache.blitline.com/listen/$id";

        return Helper::file_get_contents_curl($url);
    }

}
