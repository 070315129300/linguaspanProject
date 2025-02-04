<footer class="">
    <section class="sectionfooter">

    <div class="sectionfootermain">
        <div class="sectionfootercontent">
            <a href="/" class="footerlogo"><span style="">L</span>inguaSpan</a>
            <p>content available under a creative<br>  common license</p>
            <br>


        </div>
        <div class="footersectioncontentline">
            <div class="border-vertical">
                <p>privacy</p><br>
                <p>Terms</p><br>
                <p>Cookies</p><br>
            </div>
            <div class="border-vertical-line"></div>
            <div class="border-vertical2">
                <br>
                <p><a href="">About</a></p><br>
                <p><a href="">Github</a></p>
            </div>
        </div>

    </div>

    <div class="footeremail">
        <p> Sign up for the voice newsletter goal <br> reminder and progress update</p><br>
        <form action="">
            <div class="email-form">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit">Submit</button>
            </div>
        </form>
        <br>
        <div class="social-icons">
            <a href="#"><img src="img/facebook.png" alt=""></a>
            <a href="#"><img src="img/x.png" alt=""></a>
            <a href="#"><img src="img/instagram.png" alt=""></a>
{{--            <a href="#"><i class="fab fa-linkedin"></i></a>--}}
        </div>
        <br>
    </div>
    </section>
</footer>
<script>
    const toggleBtn = document.querySelector('menu-icon')
    const toggleBtnIcon = document.querySelector('menu-icon i')
    const dropDownMenu = document.querySelector('dropdownsidebar')

    toggleBtn.onclick = function () {
        dropDownMenu.classList.toggle('open')
        const isOpen = dropDownMenu.classList.contains('open')

        toggleBtnIcon.classList = isOpen
            ? 'fas fa-bars'
            : 'fas fa-xmark'
    }
</script>
