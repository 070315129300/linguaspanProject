@include('navbar')
{{-- </section>--}}
{{--<section class="sectionnavbar">--}}
{{--    <div>--}}
{{--        <ul>--}}
{{--            <li id="speak-tab" class="active"><img src="img/microphone.png" alt=""> Speak</li>--}}
{{--            <li id="listen-tab"><img src="img/sound4.png" alt=""> Listen</li>--}}
{{--            <li id="write-tab"><img src="img/message-edit.png" alt=""> Write</li>--}}
{{--            <li id="review-tab"><img src="img/firstline.png" alt=""> Review</li>--}}
{{--        </ul>--}}
{{--    </div>--}}

{{--</section>--}}
<section class="sectionnavbar">
    <table>
        <tr>
            <td class="hoverable active"><a href="{{url('contribute')}}" ><img src="img/microphone.png" alt="" width="15px" height="15px"> Speak</a></td>
            <td class="hoverable"><a href="{{url('listen')}}"><img src="img/sound4.png" alt="" width="15px" height="15px"> Listen</a></td>
            <td class="hoverable"><a href="{{url('write')}}"><img src="img/message-edit.png" alt="" width="15px" height="15px">  Write</a> </td>
            <td class="hoverable"><a href="{{url('review')}}"><img src="img/firstline.png" alt="" width="15px" height="15px">  Review</a> </td>
        </tr>
    </table>
</section>
<section class="speak write-section-content" id="speak-section">
    <div class="speak-content">
        <div class="speak-content-word">
            <p class="speak-content-words-p">Press <i class="fas fa-microphone"></i> then read the sentence aloud</p>
            <p class="speak-content-word-p">The man went home <br>yesterday</p>
        </div>
        <div class="speak-content-number">
            <p>Start Recording <span> 1</span></p>
            <span>2</span> <br>
            <span>3</span> <br>
            <span>4</span>
        </div>
    </div>
    <br>
    <div class="speak-content-mic"><img src="img/component4.png" alt=""></div>
    <div class="speak-content-ul">
{{--        <div class="quicktestcayleb">--}}
{{--            <p><img src="img/message-question.png" alt=""> Guidelines</p>--}}
{{--            <p><img src="img/message-question.png" alt=""> Guidelines</p>--}}
{{--            <p><img src="img/flag.png" alt="">Report</p>--}}
{{--            <p><img src="img/keyboard-open.png" alt="">Shortcut</p>--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            <p><img src="img/forward.png" alt="">Skip</p>--}}
{{--            <p>Submit</p>--}}
{{--        </div>--}}
        <div class="quicktestcayleb">
            <p> Guidelines</p>
            <p> Guidelines</p>
            <p>Report</p>
            <p>Shortcut</p>
        </div>
        <div>
            <span>Skip</span>
            <p>Submit</p>
        </div>
    </div>
</section>

@include('footer')

{{--    <script>--}}
{{--        // JavaScript to handle tab switching--}}
{{--        document.getElementById("speak-tab").addEventListener("click", function() {--}}
{{--            showSection("speak-section");--}}
{{--        });--}}

{{--        document.getElementById("listen-tab").addEventListener("click", function() {--}}
{{--            showSection("listen-section");--}}
{{--        });--}}

{{--        document.getElementById("write-tab").addEventListener("click", function() {--}}
{{--            showSection("write-section");--}}
{{--        });--}}

{{--        document.getElementById("review-tab").addEventListener("click", function() {--}}
{{--            showSection("review-section");--}}
{{--        });--}}
{{--        const tabs = document.querySelectorAll(".sectionnavbar ul li");--}}
{{--        tabs.forEach(tab => {--}}
{{--            tab.addEventListener("click", function () {--}}
{{--                // Remove 'active' class from all tabs--}}
{{--                tabs.forEach(t => t.classList.remove("active"));--}}
{{--                // Add 'active' class to the clicked tab--}}
{{--                this.classList.add("active");--}}

{{--                // Determine the section to show based on the clicked tab's ID--}}
{{--                if (this.id === "speak-tab") {--}}
{{--                    showSection("speak-section");--}}
{{--                } else if (this.id === "listen-tab") {--}}
{{--                    showSection("listen-section");--}}
{{--                } else if (this.id === "write-tab") {--}}
{{--                    showSection("write-section");--}}
{{--                } else if (this.id === "review-tab") {--}}
{{--                    showSection("review-section");--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}

{{--        function showSection(sectionId) {--}}
{{--            // Hide all sections--}}
{{--            const sections = document.querySelectorAll(".section-content");--}}
{{--            sections.forEach(section => {--}}
{{--                section.style.display = "none";--}}
{{--            });--}}

{{--            // Show the selected section--}}
{{--            document.getElementById(sectionId).style.display = "block";--}}
{{--        }--}}
{{--    </script>--}}
