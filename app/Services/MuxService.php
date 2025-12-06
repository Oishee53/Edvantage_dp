<?php
namespace App\Services;

use MuxPhp\Api\AssetsApi;
use MuxPhp\Configuration;
use MuxPhp\Models\CreateAssetRequest;
use MuxPhp\Models\InputSettings;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MuxService
{
    protected $assetsApi;
    
    public function __construct()
    {
        $tokenId = env('MUX_TOKEN_ID');
        $tokenSecret = env('MUX_TOKEN_SECRET');
        
        if (empty($tokenId) || empty($tokenSecret)) {
            throw new \Exception('Mux credentials not found in environment variables');
        }
        
        $config = Configuration::getDefaultConfiguration()
            ->setUsername($tokenId)
            ->setPassword($tokenSecret);
        
        $this->assetsApi = new AssetsApi(new Client(), $config);
    }
    
    public function uploadVideo($videoUrl)
    {
        try {
            // Validate URL
            if (!filter_var($videoUrl, FILTER_VALIDATE_URL)) {
                throw new \Exception('Invalid video URL format');
            }
            
            // Create input settings
            $inputSettings = new InputSettings([
                'url' => $videoUrl
            ]);
            
            $createAssetRequest = new CreateAssetRequest([
                'input' => [$inputSettings],
                'playback_policy' => ['public'],
            ]);
            
            $asset = $this->assetsApi->createAsset($createAssetRequest);
            
            Log::info('Mux Upload Success', [
                'asset_id' => $asset->getData()->getId(),
                'status' => $asset->getData()->getStatus()
            ]);
            
            return [
                'asset_id' => $asset->getData()->getId(),
                'playback_id' => $asset->getData()->getPlaybackIds()[0]->getId(),
                'status' => $asset->getData()->getStatus()
            ];
            
        } catch (\Exception $e) {
            Log::error('Mux Upload Error', [
                'error' => $e->getMessage(),
                'video_url' => $videoUrl
            ]);
            throw $e;
        }
    }
}