const initSearchPage = () => {
  const searchItems = document.querySelectorAll("input[name='filter']");
  const clearFilter = document.querySelector(".clear-search");
  const clearButton = document.querySelector(".clear-button");
  const posts = document.querySelectorAll(".search-form__container li");
  const showMore = document.querySelector(".show-more-button");
  let postsVisible = 11;

  if (searchItems) {
    resetResults();

    searchItems.forEach(function(item) {
      item.addEventListener("click", function(event) {
        fiterResults();
      });
    });

    function fiterResults() {
      let postTypeFilter = [];

      searchItems.forEach(function(item) {
        if (item.checked) {
          let postType = item.value;
          postTypeFilter.push(postType);
        }
      });

      posts.forEach(function(post) {
        if (postTypeFilter.includes(post.getAttribute("data-type"))) {
          post.style.display = "block";
        } else {
          post.style.display = "none";
        }
      });

      clearFilter.style.display = "block";
      showMore.style.display = "none";
    }

    if (clearButton) {
      clearButton.addEventListener("click", function(event) {
        searchItems.forEach(function(item) {
          item.checked = true;
        });

        resetResults();

        clearFilter.style.display = "none";
      });
    }

    function resetResults() {
      let count = 0;
      posts.forEach(function(post) {
        if (count <= 11) {
          post.style.display = "block";
        } else {
          post.style.display = "none";
          showMore.style.display = "block";
        }

        count++;
      });
    }

    if (showMore) {
      showMore.addEventListener("click", function(event) {
        postsVisible += 11;
        posts.forEach(function(post, index) {
          if (index <= postsVisible) {
            post.style.display = "block";
          } else {
            post.style.display = "none";
            post.setAttribute("data-visible", "false");
          }
        });

        if (postsVisible >= posts.length) {
          this.style.display = "none";
        }
      });
    }
  }
};

export default initSearchPage;
