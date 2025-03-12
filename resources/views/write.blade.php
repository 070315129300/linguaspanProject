@include('navbar')

<section class="sectionnavbar">
    <table>
        <tr>
            <td class="hoverable "><a href="{{url('contribute')}}" ><i class="iconsax" icon-name="mic-1" style="font-size: 15px"></i> Speak</a></td>
            <td class="hoverable "><a href="{{url('listen')}}"><i class="iconsax" icon-name="sound" style="font-size: 15px"></i> Listen</a></td>
            <td class="hoverable active"><a href="{{url('write')}}"><i class="iconsax" icon-name="message-edit" style="font-size: 15px"></i>  Write</a> </td>
            <td class="hoverable "><a href="{{url('review')}}"><i class="iconsax" icon-name="first-character" style="font-size: 15px"></i>  Review</a> </td>
        </tr>
    </table>

    <div>
        <select name="" id="">
            <option value="">Language</option>
            <option value="">English</option>
            <option value="">Swahili</option>
            <option value="">Yoruba</option>
            <option value="">French</option>
            <option value="">Igbo</option>
            <option value="">Hausa</option>
        </select>

    </div>
</section>
<section class="write-height write-section-content" id="write-section" >

    <div class="write-content-P">
        <p class="write-content-P-content"><i class="iconsax" icon-name="document-favorite" style="font-size: 15px"></i> Single sentence</p>
        <p> <i class="iconsax" icon-name="document-text-2" style="font-size: 15px"></i> Bulk sentence Submission</p>
    </div>
    <div class="write-content-P2">
        <p>Add <i class="iconsax" icon-name="message-edit" style="font-size: 15px"></i> a public domain sentence</p>
        <p><i>Sentence contributed here will be added to a publicly available cc- 0 licensed dataset</i></p>
    </div>
</section>
<br>
<section class="write-section-content">
    <div class="write-content-main">
        <div class="section2-profile-content-form">
            <form id="sentenceForm">
                <label for="sentence">Sentence</label> <br>
                <input type="text" id="sentence" required> <br>
                <label for="domain">Sentence domain</label><br>
                <select id="domain" required>
                    <option value="Agriculture And Food">Agriculture And Food</option>
                    <option value="Transport">Transport</option>
                    <option value="Finances">Finances</option>
                    <option value="General">General</option>
                </select> <br>
                <label for="citation">Citation</label><br>
                <input type="text" id="citation" required><br>

                <p style="display: flex; justify-content: space-between">
                    <span class="section5-about-content-span">single sentence Submission</span>
                    <i class="fas fa-plus" id="toggleIcon" onclick="toggleText()"></i>
                </p>
                <span id="languageInfo" style="display: none; font-weight: bold; width: 80%">
                    Cite with a URL or the full name of the work.
                    <span>If it's your own words, just say "Self Citation". We need
                        to know where you found this content sp that we can check it is in
                        the public  domain and no copyright restrictions apply. For more
                        information about citiation see our Guidelines page.
                    </span>
                </span><br>

            </form>
        </div>
        <div class="review-content-content">
            <p>What sentence can i add? </p>
            <ul>
                <li>fewer than 15 words per sentence</li>
                <li>Use correct grammar</li>
                <li>Use correct spelling and punctuation</li>
                <li>No numbers and special characters</li>
                <li>No foreign letters</li>
                <li>Include appropriate citation</li>
                <li>Ideally natural and conversational (it <br>
                    should be easy to read the sentence)</li>
                <li>Please use appropriate tone marks and diacritics</li>
            </ul>
        </div>
    </div>

    <div class="write-content-side-checkbox">
        <p>
            <input type="checkbox" id="confirm" required>
            I confirm that the sentence is in the public domain and I have permission to upload it.
        </p>
    </div>
    <br><br> <br> <br>
    <div class="speak-content-ul">

        <div class="section-speak-guidelines">
            <p><i class="iconsax" icon-name="question-message" style="font-size: 15px;"></i> Guidelines</p>
            <p><i class="iconsax" icon-name="flag-1" style="font-size: 15px;"></i> Contact us</p>
                    <p><i class="iconsax" icon-name="keyboard-2" style="font-size: 15px;"></i> Shortcut</p>
        </div>
        <div class="section-speak-skip">
            <p id="submitBtn" onclick="submitSentence()">Submit</p>
        </div>

    </div>
    <p id="successMessage" style="display: none; color: green; font-weight: bold;">Successfully Uploaded!</p>
    </div>

</section>




@include('footer')
<script>
    function toggleText() {
        const info = document.getElementById("languageInfo");
        const icon = document.getElementById("toggleIcon");

        // Toggle the display of the span
        if (info.style.display === "none") {
            info.style.display = "block";
            icon.classList.remove("fa-plus");
            icon.classList.add("fa-minus");
        } else {
            info.style.display = "none";
            icon.classList.remove("fa-minus");
            icon.classList.add("fa-plus");
        }
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let submitBtn = document.getElementById("submitBtn");
        let sentenceInput = document.getElementById("sentence");
        let successMessage = document.getElementById("successMessage");

        // Change submit button background when typing
        sentenceInput.addEventListener("input", function () {
            if (sentenceInput.value.trim().length > 0) {
                submitBtn.style.backgroundColor = "#00013A";
                submitBtn.style.color = "white";
            } else {
                submitBtn.style.backgroundColor = ""; // Reset
                submitBtn.style.color = "";
            }
        });

        function submitSentence() {
            let sentence = sentenceInput.value.trim();
            let domain = document.getElementById("domain").value;
            let citation = document.getElementById("citation").value.trim();
            let confirm = document.getElementById("confirm").checked;
            let type = "write";

            if (!sentence || !domain || !citation || !confirm || !type) {
                alert("Please fill all fields and confirm the checkbox.");
                return;
            }

            // Simulate sending data (replace with actual database call)
            fetch("transcriptions", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ sentence, domain, citation, type }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        successMessage.textContent = "Successfully uploaded!";
                        successMessage.style.color = "green";
                        sentenceInput.value = "";
                        submitBtn.style.backgroundColor = ""; // Reset color after submit
                        submitBtn.style.color = "";
                    } else {
                        successMessage.textContent = "Upload failed. Try again.";
                        successMessage.style.color = "red";
                    }
                })
                .catch(error => console.error("Error:", error));
        }

        // Attach event listener to submit button
        submitBtn.addEventListener("click", submitSentence);
    });
</script>

