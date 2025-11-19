<!DOCTYPE html>
<html>

@include('layout.nav')

<body>
    <div class="content">

   
    <!--- Welcome --->
    <h1 class="welcome">Welcome User</h1>
    <p class="welcome_a">to YEEKIA</p>

    <!---  --->
    <div class="pub_container">
        <h2 class="pub_h2">Bookcases and shelves for organised home</h2>
    </div>
    <p class="inf">Some of the things at home we love to see every day and display. Other are better off hidden while we don’t use them.<br>
        No matter what kind of bookshelves or shelves you’re looking for, we’re sure that we can help you out with smart<br>
        solutions for every need.</p>


    <!--- Home --->
    <div class="pub_container">
        <h2 class="pub_h2">Shop products for a more sustainable home</h2>
    </div>
    <!---------carsousel---------->
    <div class="main-carousel">
        <div class="cell"><img src="img/img1.avif"></div>
        <div class="cell"><img src="img/img1.avif"></div>
        <div class="cell"><img src="img/img2.jpg"></div>
        <div class="cell"><img src="img/img3.avif"></div></a>
        <div class="cell"><img src="img/img4.avif"></div>
        <div class="cell"><img src="img/img5.avif"></div>
        <div class="cell"><img src="img/img6.avif"></div></a>
        <div class="cell"><img src="img/img7.avif"></div>
    </div>


    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <script>
                                $('.main-carousel').flickity({
                                // options
                                cellAlign: 'left',
                                        wrapAround: true,
                                        freeScroll: true
                                });
    </script>

    <div class="pub_container2">
        <h2 class="pub_h2">Storage for the little one</h2>
    </div>
    <p class="inf">We may want them to stay small forever, but children grow up anyway – fast! We believe kid’s storage<br>
        should keep up. Our children’s storage is made to be used for years</p>
    <div><img class="pub_store" src="img/store.avif"></div>


    <div class="pub_container2">
        <h2 class="pub_h2">Shop home furniture and accessories</h2>
    </div>
    <!---------carsousel 2---------->
    <div class="main-carousel">
        <div class="cell">
            <a href="{{ route('bed_category') }}">
                <img src="{{ asset('img/image1.avif') }}">
            </a>
        </div>
        <a href="{{ route('table_category') }}">
            <div class="cell"><img src="{{ asset('img/image2.avif') }}"></div>
        </a>
        <div class="cell"><img src="img/image3.avif"></div>
        <div class="cell"><img src="img/image4.avif"></div></a>
        <div class="cell"><img src="img/image5.avif"></div>
        <div class="cell"><img src="img/image6.avif"></div>
        <div class="cell"><img src="img/image7.avif"></div>
        <div class="cell"><img src="img/image8.webp"></div>
        <div class="cell"><img src="img/image9.avif"></div>
        <div class="cell"><img src="img/image10.avif"></div>
    </div>


<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
<script>
                                $('.main-carousel').flickity({
                                // options
                                cellAlign: 'left',
                                        wrapAround: true,
                                        freeScroll: true
                                });</script>

<!-------->
<div class="pub_container2">
    <h2 class="pub_h2">More ideas and inspiration</h2>
</div>

<div class="container">

    <div class="gallery-container w-3 h-2">
        <div class="gallery-item">
            <div class="image">
                <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ"><img src="https://source.unsplash.com/1600x900/?Mirror" alt="Mirror"></a>
            </div>
            <div class="text">Mirror</div>
        </div>
    </div>

    <div class="gallery-container w-3 h-3">
        <div class="gallery-item">
            <div class="image">
                <img src="https://source.unsplash.com/1600x900/?wardrobe" alt="wardrobe">
            </div>
            <div class="text">wardrobe</div>
        </div>
    </div>

    <div class="gallery-container h-2">
        <div class="gallery-item">
            <div class="image">
                <img src="https://source.unsplash.com/1600x900/?bed" alt="bed"></a>
            </div>
            <div class="text">bed</div>
        </div>
    </div>

    <div class="gallery-container w-2 h-1">
        <div class="gallery-item">
            <div class="image">
                <img src="https://source.unsplash.com/1600x900/?dinnerware" alt="tableware">
            </div>
            <div class="text">tableware</div>
        </div>
    </div>

    <div class="gallery-container w-4 h-1">
        <div class="gallery-item">
            <div class="image">
                <img src="https://source.unsplash.com/1600x900/?mirror" alt="sofa">
            </div>
            <div class="text">sofa</div>
        </div>
    </div>

    <div class="gallery-container">
        <div class="gallery-item">
            <div class="image">
                <img src="https://source.unsplash.com/1600x900/?swiver chair" alt="chair">
            </div>
            <div class="text">chair</div>
        </div>
    </div>

    <div class="gallery-container w-4 h-2">
        <div class="gallery-item">
            <div class="image">
                <img src="https://source.unsplash.com/1600x900/?table" alt="table"></a>
            </div>
            <div class="text">table</div>
        </div>
    </div>

    <div class="gallery-container w-2 h-2">
        <div class="gallery-item">
            <div class="image">
                <img src="https://source.unsplash.com/1600x900/?plant pot" alt="plant pot">
            </div>
            <div class="text">plant pot</div>
        </div>
    </div>

</div>



<div class="pub_container2">
    <h2 class="pub_h2">Furniture and home inspiration</h2>
</div>
<p class="inf">For more than 70 years, we have worked to create a better everyday life for the many people. As a furniture and home<br> 
    furnishing store, we do this by producing furniture and accessories that are well-designed, functional and affordable.<br> 
    ere you will find everything from bedroom furniture, sofas, dining tables, chairs, wardrobes, textiles, cookware,<br>    
    decorations and more. Discover our wide range of products in-store or online!</p>    

</div>

<!-------FOOTER--------->

@include('layout/footer')

<!-- EndFooter -->
<script>

    $(document).ready (function(){
    $('#search').keyup(function(){
    var search = $('#search').val();
    if (search !== " && search !==null)
    {
    $.ajax({
    type: 'POST',
            url: 'searchResult.html',
            data: 'key=' + search,
            success:function (data)
            {
            $('#search-menu').html(data);
            }
    });
    }
    else
    {
    $(#showList').html();
    });
    $(document).on('click', 'li', function(){
    $('#search').val($(this).text());
    });
    });
</script>

</script>

</body>
</html>