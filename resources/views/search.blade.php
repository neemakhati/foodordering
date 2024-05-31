<form id="searchForm">
    <input type="text" id="searchInput" name="query" placeholder="Search food..." style="color:black;">
</form>
<section class="section">

            <div class="owl-menu-item owl-carousel owl-loaded owl-drag" >
                    <div class="owl-item">
                        <div id="searchResults" class="search-results-container" style="height: 50px; width: 200px; margin: 20px 10px; "></div>
                    </div>
            </div>

</section>



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
