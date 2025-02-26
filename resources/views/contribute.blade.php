@include('navbar')

<section class="sectionnavbar">
    <table>
        <tr>
            <td class="hoverable active"><a href="{{url('contribute')}}" ><i class="iconsax" icon-name="mic-1" style="font-size: 15px"></i> Speak</a></td>
            <td class="hoverable "><a href="{{url('listen')}}"><i class="iconsax" icon-name="sound" style="font-size: 15px"></i> Listen</a></td>
            <td class="hoverable"><a href="{{url('write')}}"><i class="iconsax" icon-name="message-edit" style="font-size: 15px"></i>  Write</a> </td>
            <td class="hoverable "><a href="{{url('review')}}"><i class="iconsax" icon-name="first-character" style="font-size: 15px"></i>  Review</a> </td>
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

    <div class="speak-content-mic"><img src="img/component4.png" alt=""></div>
    <div class="speak-content-ul">

        <div class="section-speak-guidelines">
            <p><i class="iconsax" icon-name="question-message" style="font-size: 15px;"></i> Guidelines</p>
            <p><i class="iconsax" icon-name="flag-1" style="font-size: 15px;"></i> Report</p>
            <p><i class="iconsax" icon-name="keyboard-2" style="font-size: 15px;"></i> Shortcut</p>
        </div>
        <div class="section-speak-skip">
            <p><i class="iconsax" icon-name="media-forward" style="font-size: 15px;"></i> Skip</p>

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
