
<section class="section" id="menu">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="section-heading">
                        <h6>Our Menu</h6>
                        <h2>Our selection of food with quality taste</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-item-carousel">
            <div class="col-lg-12">
                <div class="owl-menu-item owl-carousel">
                    @foreach ($data as $data)
                    <form action ="{{url('addcart',$data->id)}}" method="post">
                    @csrf
                        <div class="item">
                            <div style="background-image:url('/foodimage/{{$data->image}}');" class='card card2'>
                                <div class="price"><h6>{{$data->price}}</h6></div>
                                <div class='info'>
                                <h1 class='title'>{{$data->title}}</h1>
                                <p class='description'>{{$data->description}}</p>
                                <div class="main-text-button">
                                    <div class="scroll-to-section"><a href="#reservation"></a></div>
                                </div>
                                </div>
                            </div>
                            <input type="number" name="quantity" value="1" min="1" max="100" style="width: 50px;">
                            <input type="submit" value="Add to Cart">
                        </div>
                    </form>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
