@extends('layouts.user-index')

@section('title','Shop')

@section('style')
    <style>
        .wrapper {
            position: relative;
            overflow: hidden;

            .inside {
                z-index: 9;
                background: #f2431c;
                width: 140px;
                height: 140px;
                position: absolute;
                top: -80px;
                right: -80px;
                border-radius: 0px 0px 200px 200px;
                transition: all 0.5s, border-radius 2s, top 1s;
                overflow: hidden;

                .icon {
                    position: absolute;
                    right: 60%;
                    top: 60%;
                    color: white;
                    opacity: 1;
                }

                &:hover {
                    width: 100%;
                    right: 0;
                    top: 0;
                    border-radius: 0;
                    height: 100%;

                    .icon {
                        opacity: 0;
                        right: 15px;
                        top: 15px;
                    }

                    .contents {
                        opacity: 1;
                        transform: scale(1);
                        transform: translateY(0);
                    }
                }

                .contents {
                    padding: 5%;
                    opacity: 0;
                    transform: scale(0.5);
                    transform: translateY(-200%);
                    transition: opacity 0.2s, transform 0.8s;

                    table {
                        text-align: center;
                        width: 100%;
                        color: white;
                        font-size: 16px;
                    }

                }
            }
        }

        /* Custom CSS for styling container, cards, and buttons */
        #category-container .container-fluid {
            padding-top: 20px; /* Adjust the padding as needed */
            padding-bottom: 20px; /* Adjust the padding as needed */
        }

        #category-container .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); /* Add shadow effect */
            transition: 0.3s; /* Add transition effect on hover */
            margin-bottom: 20px; /* Adjust the margin as needed */
            border-radius: 10px; /* Add border-radius for rounded corners */
            overflow: hidden; /* Ensure contents stay within the card */

        }

        #category-container .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
        }

        #category-container .card-img-top {
            width: 100%; /* Ensure the image fills the card width */
            height: 200px; /* Adjust the height of the image as needed */
            object-fit: cover; /* Ensure the image covers the entire space */
            border-top-left-radius: 10px; /* Adjust for rounded corners */
            border-top-right-radius: 10px; /* Adjust for rounded corners */
        }

        #category-container .card-body {
            height: 200px; /* Set the height of the card body */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-bottom: 20px; /* Add margin to the bottom */
            color: black;
        }

        #category-container .btn {
            width: 100%; /* Make buttons fill the width of the card */
        }

        #category-container .card-title {
            width: 100%; /* Set a fixed width for the container */
            font-size: medium;
            white-space: nowrap;
        }
    </style>
@endsection
@section('body')
    <section class="stack-bg">
        <div class="container">
            @foreach($categories as $category)
                @if(count($category->products))
                    <section class="products">
                        <h3 class="text-capitalize">{{$category->name}}</h3>
                        <div class="row align-items-stretch">
                            @foreach($category->products as $product)
                                <div class="col-sm-6 col-md-4 col-lg-3 py-2" id="2">
                                    <div class="card mb-4 pb-2 h-100" data-stock="0">
                                        <div class="wrapper">
                                            <a href="/product/{{$product->id}}">
                                                <img src="/uploads/1719907403336.jpeg" class="card-img-top"
                                                     style="height: 240px">
                                            </a>
                                            <div class="inside">
                                                <div class="icon">Info</div>
                                                <div class="contents">
                                                    <table>
                                                        <tbody>
                                                        <tr>
                                                            <th>Description
                                                                <hr class="m-0" style="color: black;">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                {{$product->description}}
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="height: 150px;">
                                            <h5 class="card-title">{{$product->name}}</h5>
                                            <p class="card-text">{{$product->price}}</p>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-success">Buy</button>
                                                <button type="button" class="btn btn-primary" href="#">Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <hr class="m-0">
                    </section>
                @endif
            @endforeach
        </div>
    </section>
@endsection
