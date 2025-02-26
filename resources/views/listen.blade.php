@include('navbar')

<section class="sectionnavbar">
    <table>
        <tr>
            <td class="hoverable "><a href="{{url('contribute')}}" ><i class="iconsax" icon-name="mic-1" style="font-size: 15px"></i> Speak</a></td>
            <td class="hoverable active"><a href="{{url('listen')}}"><i class="iconsax" icon-name="sound" style="font-size: 15px"></i> Listen</a></td>
            <td class="hoverable"><a href="{{url('write')}}"><i class="iconsax" icon-name="message-edit" style="font-size: 15px"></i>  Write</a> </td>
            <td class="hoverable "><a href="{{url('review')}}"><i class="iconsax" icon-name="first-character" style="font-size: 15px"></i>  Review</a> </td>
        </tr>
    </table>
</section>

<section class="listen write-section-content" id="listen-section">
        <div class="speak-content">
            <div class="speak-content-word">
                <p class="speak-content-words-p">Press <img src="img/sound4.png" width="10px" alt=""> to listen & choose Yes/No to confirm if sentence was well read</p>
                <p class="speak-content-word-p">The man went home <br>yesterday</p>
            </div>
            <div class="speak-content-number">
                <p><img src="img/sound4.png" alt=""> <span> 1</span></p>
                <span>2</span> <br>
                <span>3</span> <br>
                <span>4</span>
            </div>
        </div>
        <div  class="speak-content-mic1">

            <p class="speak-content-mic2"><i class="iconsax" icon-name="tick-circle" style="font-size: 15px;color: green"></i> Yes </p>
            <img src="img/component5.png" alt="" class="speak-content-mic3" >
            <p class="speak-content-mic2"><i class="iconsax" icon-name="x-circle" style="font-size: 15px;color: red"></i> No </p>
        </div>


        <div>
            <div class="speak-content-ul">

                <div class="section-speak-guidelines">
                    <p><i class="iconsax" icon-name="question-message" style="font-size: 15px;"></i> Guidelines</p>
                    <p><i class="iconsax" icon-name="flag-1" style="font-size: 15px;"></i> Report</p>
                    <p><i class="iconsax" icon-name="keyboard-2" style="font-size: 15px;"></i> Shortcut</p>
                </div>
                <div class="section-speak-skip">
{{--                    <p><i class="iconsax" icon-name="media-forward" style="font-size: 15px;"></i> Skip</p>--}}

                    <p>Submit</p>
                </div>
            </div>
        </div>
</section>
{{--<section class="speak section-content" id="speak-section">--}}
{{--    <div class="speak-content">--}}
{{--        <div class="speak-content-word">--}}
{{--            <p>Press <i class="fas fa-microphone"></i> then read the sentence aloud</p><br>--}}
{{--            <p class="speak-content-word-p">The man went home <br>yesterday</p>--}}
{{--        </div>--}}
{{--        <div class="speak-content-number">--}}
{{--            <p>Start Recording <span> 1</span></p><br>--}}
{{--            <span>2</span> <br><br>--}}
{{--            <span>3</span> <br><br>--}}
{{--            <span>4</span> <br>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--    <br>--}}
{{--    <div class="speak-content-mic"><img src="img/component4.png" alt=""></div>--}}
{{--    <div class="speak-content-ul">--}}
{{--        <ul>--}}
{{--            <li><img src="img/message-question.png" alt=""> Guidelines</li>--}}
{{--            <li><img src="img/flag.png" alt="">Report</li>--}}
{{--            <li><img src="img/keyboard-open.png" alt="">Shortcut</li>--}}
{{--        </ul>--}}
{{--        <ul>--}}
{{--            <li><img src="img/forward.png" alt="">Skip</li>--}}
{{--            <li>Submit</li>--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--</section>--}}



{{--<section class="write section-content" id="write-section" style="display: none;">--}}

{{--    <div class="write-content-P">--}}
{{--        <p>Single sentence</p>--}}
{{--        <p>Bulk sentence Submission</p>--}}
{{--    </div>--}}
{{--    <div class="write-content-P2">--}}
{{--        <p>Add <i class="fa-regular fa-pen-to-square"></i> a public domain sentence</p>--}}
{{--        <p>Sentence contributed here will be added to a publicly available cc- 0 licensed dataset</p>--}}
{{--    </div>--}}

{{--    <div class="write-content-main">--}}
{{--        <div class="write-content-main-form">--}}
{{--            <form action="">--}}
{{--                <label for="">Sentence</label> <br>--}}
{{--                <input type="text"> <br>--}}
{{--                <label for="">Sentence domain</label>--}}
{{--                <input type="text"> <br>--}}
{{--                <label for=""> Citation</label>--}}
{{--                <input type="text">--}}
{{--                <p>single sentence Submission</p>--}}

{{--            </form>--}}
{{--        </div>--}}
{{--        <div class="write-content-main-side">--}}
{{--            <p>What sentence can i add? </p>--}}
{{--            <ul>--}}
{{--                <li>fewer than 15 words per sentence</li>--}}
{{--                <li>Use correct grammar</li>--}}
{{--                <li>Use correct spelling and punctuation</li>--}}
{{--                <li>No numbers and special characters</li>--}}
{{--                <li>No foreign letters</li>--}}
{{--                <li>Include appropriate citation</li>--}}
{{--                <li>Ideally natural and conversational (it <br>--}}
{{--                    should be easy to read the sentence</li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="write-content-side-checkbox">--}}
{{--        <p>i can confirm that the sentence is a public domain and <br> i have permission to upload it </p>--}}
{{--    </div>--}}

{{--    <div class="write-content-main-ul">--}}
{{--        <ul>--}}
{{--            <li> Guidelines</li>--}}
{{--            <li>Contact us</li>--}}
{{--        </ul>--}}
{{--        <p>submit</p>--}}
{{--    </div>--}}


{{--</section>--}}

{{--<section class="review section-content" id="review-section" style="display: none;">--}}

{{--    <div>--}}
{{--        <div>--}}
{{--            <p>Press <i class="fa-solid fa-book"></i> then read the sentence aloud</p>--}}
{{--            <p>The man went home yesterday</p>--}}
{{--            <div>--}}
{{--                <ul>--}}
{{--                    <li>yes</li>--}}
{{--                    <li>No Skip</li>--}}
{{--                    <li>No</li>--}}
{{--                </ul>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            <p>Does the sentence meet the guidelines? </p>--}}
{{--            <ul>--}}
{{--                <li>fewer than 15 words per sentence</li>--}}
{{--                <li>Use correct grammar</li>--}}
{{--                <li>Use correct spelling and punctuation</li>--}}
{{--                <li>No numbers and special characters</li>--}}
{{--                <li>No foreign letters</li>--}}
{{--                <li>Include appropriate citation</li>--}}
{{--                <li>Ideally natural and conversational (it <br>--}}
{{--                    should be easy to read the sentence</li>--}}

{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div>--}}
{{--        <div>--}}
{{--            <ul>--}}
{{--                <li> Guidelines</li>--}}
{{--                <li>Report</li>--}}
{{--                <li>Shortcut</li>--}}
{{--            </ul>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}

@include('footer')

{{--<script>--}}
{{--    // JavaScript to handle tab switching--}}
{{--    document.getElementById("speak-tab").addEventListener("click", function() {--}}
{{--        showSection("speak-section");--}}
{{--    });--}}

{{--    document.getElementById("listen-tab").addEventListener("click", function() {--}}
{{--        showSection("listen-section");--}}
{{--    });--}}

{{--    document.getElementById("write-tab").addEventListener("click", function() {--}}
{{--        showSection("write-section");--}}
{{--    });--}}

{{--    document.getElementById("review-tab").addEventListener("click", function() {--}}
{{--        showSection("review-section");--}}
{{--    });--}}
{{--    const tabs = document.querySelectorAll(".sectionnavbar ul li");--}}
{{--    tabs.forEach(tab => {--}}
{{--        tab.addEventListener("click", function () {--}}
{{--            // Remove 'active' class from all tabs--}}
{{--            tabs.forEach(t => t.classList.remove("active"));--}}
{{--            // Add 'active' class to the clicked tab--}}
{{--            this.classList.add("active");--}}

{{--            // Determine the section to show based on the clicked tab's ID--}}
{{--            if (this.id === "speak-tab") {--}}
{{--                showSection("speak-section");--}}
{{--            } else if (this.id === "listen-tab") {--}}
{{--                showSection("listen-section");--}}
{{--            } else if (this.id === "write-tab") {--}}
{{--                showSection("write-section");--}}
{{--            } else if (this.id === "review-tab") {--}}
{{--                showSection("review-section");--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}

{{--    function showSection(sectionId) {--}}
{{--        // Hide all sections--}}
{{--        const sections = document.querySelectorAll(".section-content");--}}
{{--        sections.forEach(section => {--}}
{{--            section.style.display = "none";--}}
{{--        });--}}

{{--        // Show the selected section--}}
{{--        document.getElementById(sectionId).style.display = "block";--}}
{{--    }--}}
{{--</script>--}}
