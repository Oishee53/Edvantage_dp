<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class DailyService
{
    protected Client $client;
    protected string $apiKey;
    protected string $baseUrl = 'https://api.daily.co/v1';

    public function __construct()
    {
        $this->apiKey = env('DAILY_API_KEY');
        $this->client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ],
        ]);
    }

    /**
     * Create a Daily room for a session.
     * Returns room_name and room_url.
     */
    public function createRoom(int $courseId, int $sessionNumber): array
    {
        $roomName = "course-{$courseId}-session-{$sessionNumber}-" . time();

        $response = $this->client->post("{$this->baseUrl}/rooms", [
            'json' => [
                'name'       => $roomName,
                'privacy'    => 'private',
                'properties' => [
                    'enable_chat'        => true,
                    'enable_screenshare' => true,
                    'start_video_off'    => false,
                    'start_audio_off'    => false,
                    'exp'                => time() + (60 * 60 * 12),
                ],
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        Log::info('Daily room created', ['room' => $roomName]);

        return [
            'room_name' => $data['name'],
            'room_url'  => $data['url'],
        ];
    }

    /**
     * Generate a meeting token for a participant.
     * is_owner = true for instructor (can start recording, manage room).
     */
    public function createToken(string $roomName, string $userName, bool $isOwner = false): string
    {
        $response = $this->client->post("{$this->baseUrl}/meeting-tokens", [
            'json' => [
                'properties' => [
                'room_name'  => $roomName,
                'user_name'  => $userName,
                'is_owner'   => $isOwner,
                'exp'        => time() + (60 * 60 * 12),
            ],
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        return $data['token'];
    }

    /**
     * Get recordings for a room.
     * Returns the most recent recording download URL, or null if none.
     */
    public function getRecordingUrl(string $roomName): ?string
    {
        try {
            $response = $this->client->get("{$this->baseUrl}/recordings", [
                'query' => ['room_name' => $roomName],
            ]);

            $data       = json_decode($response->getBody(), true);
            $recordings = $data['data'] ?? [];

            if (empty($recordings)) {
                return null;
            }

            $latest = collect($recordings)
                ->where('status', 'finished')
                ->sortByDesc('created_at')
                ->first();

            if (!$latest) {
                return null;
            }

            $recordingId  = $latest['id'];
            $linkResponse = $this->client->get("{$this->baseUrl}/recordings/{$recordingId}/access-link");
            $linkData     = json_decode($linkResponse->getBody(), true);

            return $linkData['download_link'] ?? null;

        } catch (\Exception $e) {
            Log::error('Failed to fetch Daily recording:', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Delete a Daily room when no longer needed.
     */
    public function deleteRoom(string $roomName): void
    {
        try {
            $this->client->delete("{$this->baseUrl}/rooms/{$roomName}");
            Log::info('Daily room deleted', ['room' => $roomName]);
        } catch (\Exception $e) {
            Log::warning('Failed to delete Daily room:', ['error' => $e->getMessage()]);
        }
    }
}