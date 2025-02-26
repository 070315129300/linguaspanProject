@include('navbar')

<section class="sectionnavbar">
    <table>
        <tr>
            <td class="hoverable "><a href="{{url('contribute')}}" ><i class="iconsax" icon-name="mic-1" style="font-size: 15px"></i> Speak</a></td>
            <td class="hoverable "><a href="{{url('listen')}}"><i class="iconsax" icon-name="sound" style="font-size: 15px"></i> Listen</a></td>
            <td class="hoverable"><a href="{{url('write')}}"><i class="iconsax" icon-name="message-edit" style="font-size: 15px"></i>  Write</a> </td>
            <td class="hoverable active"><a href="{{url('review')}}"><i class="iconsax" icon-name="first-character" style="font-size: 15px"></i>  Review</a> </td>
        </tr>

    </table>
</section>
<br>
<section class="review write-section-content" id="review-section">

    <div class="review-content">
{{--        <div class="review-content-word">--}}
{{--            <p class="speak-content-words-p">Press <i class="iconsax" icon-name="sound" style="font-size: 15px"></i> to listen & choose Yes/No to confirm if sentence was well read</p>--}}
{{--            <br>--}}
{{--            <p class="speak-content-word-p">The man went home <br>--}}
{{--                yesterday</p>--}}
{{--            <br>--}}
{{--            <div  class="review-content-mic1">--}}
{{--                <p class="speak-content-mic2"><i class="iconsax" icon-name="tick-circle" style="font-size: 15px;color: green"></i>  Yes </p>--}}
{{--                <p class="speak-content-mic2"><i class="iconsax" icon-name="media-forward" style="font-size: 15px;"></i> No Skip </p>--}}
{{--                <p class="speak-content-mic2"><i class="iconsax" icon-name="x-circle" style="font-size: 15px;color: red"></i>  No </p>--}}
{{--            </div>--}}

{{--        </div>--}}

        <div class="review-content-word">
            <p class="speak-content-words-p">
                Press <i class="iconsax" icon-name="sound" style="font-size: 15px"></i> to listen & choose Yes/No to confirm if the sentence was well read
            </p>
            <br>
            <p class="speak-content-word-p" id="review-text">Loading...</p>
            <br>
{{--            <div class="review-content-mic1">--}}
{{--                <p class="speak-content-mic2" onclick="submitReview('ok')">--}}
{{--                    <i class="iconsax" icon-name="tick-circle" style="font-size: 15px;color: green"></i> Yes--}}
{{--                </p>--}}
{{--                <p class="speak-content-mic2" onclick="loadNextReview()">--}}
{{--                    <i class="iconsax" icon-name="media-forward" style="font-size: 15px;"></i> No Skip--}}
{{--                </p>--}}
{{--                <p class="speak-content-mic2" onclick="submitReview('rejected')">--}}
{{--                    <i class="iconsax" icon-name="x-circle" style="font-size: 15px;color: red"></i> No--}}
{{--                </p>--}}
{{--            </div>--}}
            <div class="review-content-mic1">
                <button class="speak-content-mic2" onclick="submitReview('approved')">
                    <i class="iconsax" icon-name="tick-circle" style="font-size: 15px;color: green"></i> Yes
                </button>
                <button class="speak-content-mic2" onclick="loadNextReview()">
                    <i class="iconsax" icon-name="media-forward" style="font-size: 15px;"></i> No Skip
                </button>
                <button class="speak-content-mic2" onclick="submitReview('rejected')">
                    <i class="iconsax" icon-name="x-circle" style="font-size: 15px;color: red"></i> No
                </button>
            </div>
        </div>
        <div class="review-content-content">
            <p>Does the sentence meet the guidelines? </p>
            <ul style="list-style-type: circle !important;">
                <li>fewer than 15 words per sentence</li>
                <li>Use correct grammar</li>
                <li>Use correct spelling and punctuation</li>
                <li>No numbers and special characters</li>
                <li>No foreign letters</li>
                <li>Include appropriate citation</li>
                <li>Ideally natural and conversational (it <br>
                    should be easy to read the sentence</li>
            </ul>
        </div>
    </div>

    <div class="speak-content-ul">

        <div class="section-speak-guidelines">
            <p><i class="iconsax" icon-name="question-message" style="font-size: 15px;"></i> Guidelines</p>
            <p><i class="iconsax" icon-name="flag-1" style="font-size: 15px;"></i> Report</p>
            <p><i class="iconsax" icon-name="keyboard-2" style="font-size: 15px;"></i> Shortcut</p>
        </div>
        <div class="section-speak-skip">
            {{--                    <p><i class="iconsax" icon-name="media-forward" style="font-size: 15px;"></i> Skip</p>--}}

{{--            <p>Submit</p>--}}
        </div>
    </div>
</section>

@include('footer')


<script>
    let currentReviewId = null;

    // Fetch the next review
    function loadNextReview() {
        fetch('/getreview/next')
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    document.getElementById('review-text').innerText = 'No more reviews available';
                    currentReviewId = null;
                } else {
                    document.getElementById('review-text').innerText = data.sentence; // Ensure this matches your column name
                    currentReviewId = data.id;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Submit review decision
    function submitReview(status) {
        console.log('Submitting review with status:', status);
        if (!currentReviewId) {
            console.log('No review ID found');
            return;
        }
        fetch(`/getreview/${currentReviewId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
                loadNextReview();
            })
            .catch(error => console.error('Error:', error));
    }

    // Load the first review when the page loads
    document.addEventListener('DOMContentLoaded', loadNextReview);
</script>


