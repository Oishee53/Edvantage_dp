{{-- Video Section --}}
@auth
    @if($resource->videos)
        <div style="margin: 20px 0;">
            <div><strong>Video Content</strong></div>

            <button onclick="toggleVideo()">View Video</button>

            <div id="videoPlayer" style="margin-top: 20px; display: none;">
                <mux-player 
                    playback-id="{{ $resource->videos }}"
                    stream-type="on-demand"
                    controls
                    style="width: 100%; max-width: 720px;">
                </mux-player>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@mux/mux-player"></script>
        <script>
            function toggleVideo() {
                const player = document.getElementById('videoPlayer');
                player.style.display = (player.style.display === 'none') ? 'block' : 'none';
            }
        </script>
    @endif
    @if($resource->pdf)
        <div style="margin: 20px 0;">
            <div><strong>PDF Document</strong></div>
            <a href="{{ route('secure.pdf.view', ['id' => $resource->id]) }}" 
               target="_blank" 
               rel="noopener noreferrer">
                <button>View PDF</button>
            </a>
        </div>
    @endif
@else
    <p><em>Please log in to view the video.</em></p>
@endif
