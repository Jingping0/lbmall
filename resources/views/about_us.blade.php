<!DOCTYPE html>

<html>
    @include('layout.subNav')

    <body>
        <!-------aboutUs------->

        <section class="about">
            <div class="main">
                <img src="img/about.jpg" alt="">
                <div class="all-text">
                    <h4>About Us</h4>
                    <h2>A House Of Creative & Intelligent</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Dolores sunt nostrum ab repellendus? Id quas porro aliquam? 
                        Porro dolorum ex minima optio, saepe est cupiditate veritatis 
                        eaque, molestiae omnis animi.
                    </p>
                    <div class="button">
                        <button type="button" onclick="location.href='{{ route('home') }}';">Explore</button>
                        <button type="button" onclick="location.href='{{ route('contact') }}';">Contact Us</button>
                    </div>
                </div>
            </div>

        </section>

        <!-------FOOTER--------->
        @include('layout.footer')

    </body>
</html>