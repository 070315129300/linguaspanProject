@include('navbar')

<section class="section-languages">
    <div>
        <h2>Languages</h2>
        <span>Last Update 17th Feb. 2025 10:00am</span>
       <div class="section-languages-head">
           <form action="">
               <div class="email-form-language">
                   <input type="email" placeholder="Search for language" required>
                   <button type="submit">Submit</button>
               </div>
           </form>
       </div>
    </div>
</section>


<section class="section1language">
    <div>
        <div class="section1languagehead">
            <p>Published Languages</p>
            <p id="viewMoreBtn" style="color: #4F4F4F; cursor: pointer;">View more</p>
        </div>
        <div class="section1languagehead-main">
            <p>For these launched languages the website has been successfully localized and has <br>
                enough sentence collected to allow for ongoing Speak and Listen contributions.</p>
        </div>
        <div class="section1-languages-main">
            @foreach($languages as $index => $language)
                @if($index < 3)  {{-- Show only the first three --}}
                <div class="section-main-lang">
                    <div class="section-languages-main">
                        <div>
                            <p class="section-languages-main-span1"> {{$language->language}}</p> <br>
                            <p class="section-languages-hour"><i class="iconsax" icon-name="stopwatch"></i> Hours </p>
                            {{$language->total}} <br><br>
                            <p class="section-languages-hour"><i class="iconsax" icon-name="tick-circle"></i> Validation Progress</p>
                            {{$language->approved_hours}}
                        </div>
                        <div>
                            <p class="section-languages-main-span2"><a href="{{url('dataCollection')}}">view details </a><i class="fas fa-ellipsis-v menu-dots"></i></p> <br>
                            <p class="section-languages-hour"><i class="iconsax" icon-name="mic-2"></i> Speakers</p>
                            {{$language->speakers}} <br> <br>
                            <p class="section-languages-hour" ><i class="iconsax" icon-name="first-character"></i> Sentences</p>
                            {{$language->writers}}
                        </div>
                    </div>
                    <p class="section-languages-contribute">Contribute</p>
                </div>
                @endif
            @endforeach
        </div>

        <div class="section1-languages-main" id="hiddenLanguagesSection" style="display: none;">
            @foreach($languages as $index => $language)
                @if($index >= 3)  {{-- Remaining languages go here --}}
                <div class="section-main-lang">
                    <div class="section-languages-main">
                        <div>
                            <p class="section-languages-main-span1"> {{$language->language}}</p> <br>
                            <p class="section-languages-hour"><i class="iconsax" icon-name="stopwatch"></i> Hours </p>
                            {{$language->total}} <br><br>
                            <p class="section-languages-hour"><i class="iconsax" icon-name="tick-circle"></i> Validation Progress</p>
                            {{$language->approved_hours}}
                        </div>

                        <div>
                            <p class="section-languages-main-span2"><a href="{{url('dataCollection')}}">view details </a><i class="fas fa-ellipsis-v menu-dots"></i></p> <br>
                            <p class="section-languages-hour"><i class="iconsax" icon-name="mic-2"></i> Speakers</p>
                            {{$language->speakers}} <br> <br>
                            <p class="section-languages-hour" ><i class="iconsax" icon-name="first-character"></i> Sentences</p>
                            {{$language->writers}}
                        </div>
                    </div>
                    <p class="section-languages-contribute">Contribute</p>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</section>

{{-- Hidden Section --}}
{{--<section class="section1language">--}}
{{--    <div class="section1-languages-main" id="hiddenLanguagesSection" style="display: none;">--}}
{{--        @foreach($languages as $index => $language)--}}
{{--            @if($index >= 3)  --}}{{-- Remaining languages go here --}}
{{--            <div class="section-main-lang">--}}
{{--                <div class="section-languages-main">--}}
{{--                    <div>--}}
{{--                        <p class="section-languages-main-span1"> {{$language->language}}</p> <br>--}}
{{--                        <p class="section-languages-hour"><i class="iconsax" icon-name="stopwatch"></i> Hours </p>--}}
{{--                        {{$language->total}} <br><br>--}}
{{--                        <p class="section-languages-hour"><i class="iconsax" icon-name="tick-circle"></i> Validation Progress</p>--}}
{{--                        {{$language->approved_hours}}--}}
{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <p class="section-languages-main-span2"><a href="{{url('dataCollection')}}">view details </a><i class="fas fa-ellipsis-v menu-dots"></i></p> <br>--}}
{{--                        <p class="section-languages-hour"><i class="iconsax" icon-name="mic-2"></i> Speakers</p>--}}
{{--                        {{$language->speakers}} <br> <br>--}}
{{--                        <p class="section-languages-hour" ><i class="iconsax" icon-name="first-character"></i> Sentences</p>--}}
{{--                        {{$language->writers}}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <p class="section-languages-contribute">Contribute</p>--}}
{{--            </div>--}}
{{--            @endif--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--</section>--}}

<section class="section1language">
    <div>
        <div class="section1languagehead">
            <p>In Progress Languages</p>
            <p id="viewMoresBtn" style="color: #4F4F4F; cursor: pointer;">View more</p>
        </div>
        <div class="section1languagehead-main">
            <p>The languages are currently under community development. Website localization and <br>
                sentence collected is needed to launch.</p>
        </div>
        <div class="section1-languages-main">
            <div class="section-main-lang">
                <div class="section-languages-main">
                    <div>
                        <p class="section-languages-main-span1">English</p> <br>
                        <p class="section-languages-hour"><i class="iconsax" icon-name="stopwatch"></i> Hours </p>
                        2,345 <br><br>
                        <p class="section-languages-hour"><i class="iconsax" icon-name="tick-circle"></i> Validation Progress</p>
                        2,345
                    </div>

                    <div>
                        <p class="section-languages-main-span2"><a href="{{url('dataCollection')}}">view details </a> <i class="fas fa-ellipsis-v menu-dots"></i></p> <br>
                        <p class="section-languages-hour"><i class="iconsax" icon-name="mic-2"></i> Speakers</p>
                        21,345 <br> <br>
                        <p class="section-languages-hour" ><i class="iconsax" icon-name="first-character"></i> Sentences</p>
                        2,345
                    </div>
                </div>
                <p class="section-languages-contribute">Contribute</p>

            </div>

            <div class="section-main-lang">
                <div class="section-languages-main">
                    <div>
                        <p class="section-languages-main-span1">English</p> <br>
                        <p class="section-languages-hour"><i class="iconsax" icon-name="stopwatch"></i> Hours </p>
                        2,345 <br><br>
                        <p class="section-languages-hour"><i class="iconsax" icon-name="tick-circle"></i> Validation Progress</p>
                        2,345
                    </div>

                    <div>
                        <p class="section-languages-main-span2"><a href="{{url('dataCollection')}}">view details </a> <i class="fas fa-ellipsis-v menu-dots"></i></p> <br>
                        <p class="section-languages-hour"><i class="iconsax" icon-name="mic-2"></i> Speakers</p>
                        21,345 <br> <br>
                        <p class="section-languages-hour" ><i class="iconsax" icon-name="first-character"></i> Sentences</p>
                        2,345
                    </div>
                </div>
                <p class="section-languages-contribute">Contribute</p>

            </div>
            <div class="section-main-lang">
                <div class="section-languages-main">
                    <div>
                        <p class="section-languages-main-span1">English</p> <br>
                        <p class="section-languages-hour"><i class="iconsax" icon-name="stopwatch"></i> Hours </p>
                        2,345 <br><br>
                        <p class="section-languages-hour"><i class="iconsax" icon-name="tick-circle"></i> Validation Progress</p>
                        2,345
                    </div>

                    <div>
                        <p class="section-languages-main-span2"><a href="{{url('dataCollection')}}">view details </a> <i class="fas fa-ellipsis-v menu-dots"></i></p> <br>
                        <p class="section-languages-hour"><i class="iconsax" icon-name="mic-2"></i> Speakers</p>
                        21,345 <br> <br>
                        <p class="section-languages-hour" ><i class="iconsax" icon-name="first-character"></i> Sentences</p>
                        2,345
                    </div>
                </div>
                <p class="section-languages-contribute">Contribute</p>

            </div>
        </div>
    </div>
</section>

<section class="section1language">
    <div class="section1-languages-main" id="hiddenLanguagesSections" style="display: none;">
        <div class="section-main-lang">
            <div class="section-languages-main">
                <div>
                    <p class="section-languages-main-span1">English</p> <br>
                    <p class="section-languages-hour"><i class="iconsax" icon-name="stopwatch"></i> Hours </p>
                    2,345 <br><br>
                    <p class="section-languages-hour"><i class="iconsax" icon-name="tick-circle"></i> Validation Progress</p>
                    2,345
                </div>

                <div>
                    <p class="section-languages-main-span2"><a href="{{url('dataCollection')}}">view details </a> <i class="fas fa-ellipsis-v menu-dots"></i></p> <br>
                    <p class="section-languages-hour"><i class="iconsax" icon-name="mic-2"></i> Speakers</p>
                    21,345 <br> <br>
                    <p class="section-languages-hour" ><i class="iconsax" icon-name="first-character"></i> Sentences</p>
                    2,345
                </div>
            </div>
            <p class="section-languages-contribute">Contribute</p>

        </div>

        <div class="section-main-lang">
            <div class="section-languages-main">
                <div>
                    <p class="section-languages-main-span1">English</p> <br>
                    <p class="section-languages-hour"><i class="iconsax" icon-name="stopwatch"></i> Hours </p>
                    2,345 <br><br>
                    <p class="section-languages-hour"><i class="iconsax" icon-name="tick-circle"></i> Validation Progress</p>
                    2,345
                </div>

                <div>
                    <p class="section-languages-main-span2"><a href="{{url('dataCollection')}}">view details </a> <i class="fas fa-ellipsis-v menu-dots"></i></p> <br>
                    <p class="section-languages-hour"><i class="iconsax" icon-name="mic-2"></i> Speakers</p>
                    21,345 <br> <br>
                    <p class="section-languages-hour" ><i class="iconsax" icon-name="first-character"></i> Sentences</p>
                    2,345
                </div>
            </div>
            <p class="section-languages-contribute">Contribute</p>

        </div>
        <div class="section-main-lang">
            <div class="section-languages-main">
                <div>
                    <p class="section-languages-main-span1">English</p> <br>
                    <p class="section-languages-hour"><i class="iconsax" icon-name="stopwatch"></i> Hours </p>
                    2,345 <br><br>
                    <p class="section-languages-hour"><i class="iconsax" icon-name="tick-circle"></i> Validation Progress</p>
                    2,345
                </div>

                <div>
                    <p class="section-languages-main-span2"><a href="{{url('dataCollection')}}">view details </a> <i class="fas fa-ellipsis-v menu-dots"></i></p> <br>
                    <p class="section-languages-hour"><i class="iconsax" icon-name="mic-2"></i> Speakers</p>
                    21,345 <br> <br>
                    <p class="section-languages-hour" ><i class="iconsax" icon-name="first-character"></i> Sentences</p>
                    2,345
                </div>
            </div>
            <p class="section-languages-contribute">Contribute</p>

        </div>
    </div>
    </div>
</section>
@include("footer")

<script>

    document.getElementById("viewMoreBtn").addEventListener("click", function() {
        var hiddenSection = document.getElementById("hiddenLanguagesSection");

        if (hiddenSection.style.display === "none" || hiddenSection.style.display === "") {
            // Check if it's mobile view
            if (window.innerWidth <= 500) {
                hiddenSection.style.display = "block"; // Use block on mobile
            } else {
                hiddenSection.style.display = "flex"; // Use flex on larger screens
            }
            this.innerText = "View less";
        } else {
            hiddenSection.style.display = "none";
            this.innerText = "View more";
        }
    });
    document.getElementById("viewMoresBtn").addEventListener("click", function() {
        var hiddenSection = document.getElementById("hiddenLanguagesSections");
        if (hiddenSection.style.display === "none" || hiddenSection.style.display === "") {
            // Check if it's mobile view
            if (window.innerWidth <= 500) {
                hiddenSection.style.display = "block"; // Use block on mobile
            } else {
                hiddenSection.style.display = "flex"; // Use flex on larger screens
            }
            this.innerText = "View less";
        } else {
            hiddenSection.style.display = "none";
            this.innerText = "View more";
        }
    });
</script>
