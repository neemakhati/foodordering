<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    @include('homecss')
    
</head>
<body>
    @extends('homeheader')

    @section('search')
        @include('search')
    @endsection

    <div id="banner">@include('banner')</div>
    <div id="about">@include('about')</div>
    <div id="food">@include('food')</div>
    <div id="trend">@include('trend')</div>
    <div id="footer">@include('homefooter')</div>

    

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById("searchInput");
            

            searchInput.addEventListener("input", searchFood);
            searchInput.addEventListener("keydown", handleBackspace);

            function searchFood(event) {
                var query = searchInput.value;

                if (query.trim() === "") {
                    toggleSections(false);
                    document.getElementById("searchResults").innerHTML = "";
                    return;
                } else {
                    toggleSections(true);
                }

                var req = new XMLHttpRequest();
                req.open("GET", "{{ route('food.search') }}?query=" + encodeURIComponent(query), true);
                req.onreadystatechange = function () {
                    if (req.readyState == 4) {
                        if (req.status == 200) {
                            var response = JSON.parse(req.responseText);
                            var searchResults = document.getElementById("searchResults");
                            searchResults.innerHTML = response.html;
                            highlightMatchedLetters(query);
                        } else {
                            console.error("Request failed with status: " + req.status);
                        }
                    }
                };
                req.send();
            }
            function handleBackspace(event) {
                if (event.key === "Backspace") {
                    toggleSections(false);
                    document.getElementById("searchResults").innerHTML = "";
                }
            }

            function highlightMatchedLetters(query) {
                var searchResultItems = document.querySelectorAll(".search-result");
                searchResultItems.forEach(function(item) {
                    var titleText = item.querySelector("p").innerText;

                    var highlightedTitle = "";
                    var lastIndex = 0;

                    var lowerQuery = query.toLowerCase();
                    var lowerTitleText = titleText.toLowerCase();

                    for (var i = 0; i < lowerQuery.length; i++) {
                        var index = lowerTitleText.indexOf(lowerQuery[i], lastIndex);
                        if (index !== -1) {
                            highlightedTitle += titleText.substring(lastIndex, index);
                            highlightedTitle += '<span style="background-color: yellow;">' + titleText.substr(index, 1) + '</span>';
                            lastIndex = index + 1;
                        } else {
                            highlightedTitle += titleText.substring(lastIndex);
                            break;
                        }
                    }
                    highlightedTitle += titleText.substring(lastIndex);

                    item.querySelector("p").innerHTML = highlightedTitle;
                });
            }

            function toggleSections(hide) {
                var sections = ["banner", "about", "food", "trend","footer"];
                sections.forEach(function(section) {
                    var element = document.getElementById(section);
                    if (element) {
                        console.log('Toggling section:', section, 'to', hide ? 'none' : 'block');
                        element.style.display = hide ? "none" : "block";
                    } else {
                        console.error('Element not found:', section); 
                    }
                });
            }
        });
    </script>

    @include('homescripts')

</body>
</html>
