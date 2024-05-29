<form id="searchForm">
    <input type="text" id="searchInput" name="query" placeholder="Search food..." style="color:black;">
</form>
<div id="searchResults" class="search-results-container"></div>

<style>
    .search-results-container {
        position: absolute;
        margin-top: 100px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .search-result {
        background-color: #fb5849;
        color: white;
        padding: 20px;
        margin: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .search-result:hover {
        transform: translateY(-5px);
    }

    .search-result img {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .search-result p {
        margin: 0;
    }
</style>


<script>
function searchFood(event) {
    event.preventDefault(); 
    var query = document.getElementById("searchInput").value;

    var req = new XMLHttpRequest();
    req.open("GET", "{{ route('food.search') }}?query=" + query, true);
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
document.getElementById("searchInput").addEventListener("input", searchFood);

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
</script>
