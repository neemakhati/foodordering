<!DOCTYPE html>
<html lang="en">
<head>
    @include('homecss')
    <title>Food Detail</title>
    <style>
        .food-detail {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background: #fff;
            max-width: 600px;
            margin: 120px auto;
        }

        .food-detail img {
            width: 100%;
            max-width: 400px;
            height: auto;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .food-title {
            font-size: 2em;
            margin-bottom: 10px;
            color: #333;
        }

        .food-price {
            font-size: 1.5em;
            color: #fb5849;
            margin-bottom: 20px;
        }

        .stars {
            display: flex;
            gap: 5px;
            cursor: pointer;
            font-size: 30px;
            justify-content: center;
        }

        .star {
            color: #ccc;
            transition: color 0.2s;
        }

        .star.selected {
            color: #ff0;
        }

        .comments {
            margin-top: 30px;
            width: 100%;
        }

        .comments h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        .comment-box {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background: #f9f9f9;
        }

        .comment-box img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .comment-content {
            flex: 1;
            width: 100%;
        }

        .comment-content .user-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-bottom: 5px;
        }

        .comment-content .user-name {
            font-weight: bold;
            margin-right: 10px;
            margin-left: 80px;
            margin-top: -50px;
        }

        .comment-content .comment-time {
            font-size: 12px;
            color: #999;
        }

        .comment-content .user-rating {
            color: #ff0;
            margin-bottom: 5px;
            margin-left: 80px;
            margin-top: -70px;
        }

        .comment-content .user-comment {
            font-size: 14px;
            color: #555;
            margin-left: 80px;
            margin-top: 20px;
        }

        textarea#comment {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            resize: vertical;
        }

        button#submit-comment {
            padding: 10px 20px;
            background-color: #fb5849;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
@extends('homeheader')

<div class="container">
    <div class="food-detail">
        <h1 class="food-title">{{ $food->title }}</h1>
        <img src="/foodimage/{{ $food->image }}" alt="{{ $food->title }}">
        <p class="food-price">Price: {{ $food->price }}</p>
        <p>{{ $food->description }}</p>

        <div class="rating">
            <h2>Rate this food</h2>
            <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                    <span class="star" data-value="{{ $i }}">&#9733;</span>
                @endfor
            </div>
        </div>

        <div class="comments">
            <h2>Comments</h2>
            <textarea id="comment" placeholder="Leave a comment"></textarea>
            <button id="submit-comment">Post</button>

        </div>
    </div>
    <div id="comment-list">
        @foreach($comments as $comment)
            <div class="comment-box">
                <img src="https://via.placeholder.com/50" alt="User Icon">
                <div class="comment-content">
                    <div class="user-info">
                        <div class="user-name">{{ $comment->user->name }}</div>
                        <div class="comment-time">{{ $comment->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="user-rating">{!! str_repeat('&#9733;', $comment->rate) !!}</div>
                    <div class="user-comment">{{ $comment->comment }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@include('homefooter')
@include('homescripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let rating = 0;

        document.querySelectorAll('.star').forEach(function(star) {
            star.addEventListener('click', function() {
                rating = this.getAttribute('data-value');
                updateStars(rating);
            });
        });

        function updateStars(rating) {
            document.querySelectorAll('.star').forEach(function(star) {
                star.classList.remove('selected');
            });
            for (let i = 1; i <= rating; i++) {
                document.querySelector(`.star[data-value="${i}"]`).classList.add('selected');
            }
        }

        document.getElementById('submit-comment').addEventListener('click', function() {
            let comment = document.getElementById('comment').value;

            fetch('/review', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    food_id: {{ $food->id }},
                    rate: rating,
                    comment: comment
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let commentList = document.getElementById('comment-list');
                        let newComment = document.createElement('div');
                        newComment.classList.add('comment-box');
                        newComment.innerHTML = `
                        <img src="https://via.placeholder.com/50" alt="User Icon">
                        <div class="comment-content">
                            <div class="user-info">
                                <div class="user-name">{{ auth()->user()->name }}</div>
                            </div>
                            <div class="user-rating">${'&#9733;'.repeat(rating)}</div>
                            <div class="user-comment">${comment}</div>
                            <div class="comment-time">Just now</div>
                        </div>
                    `;
                        commentList.prepend(newComment);
                        document.getElementById('comment').value = '';
                        rating = 0;
                        updateStars(rating);
                    }
                });
        });
    });
</script>
</body>
</html>
