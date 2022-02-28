import { ajax } from "./utils.js";
(function () {
  $(document).ready(function () {
    $(".input-search").keyup(function () {
      // console.log($(".submit-search"));
      // if (this.keyCode === 13) {
      //     $(".submit-search").click();
      // }

      if ($(this).val() === "") {
        $(".result-search").html("");
        $(".search").removeClass("show");
      } else
        ajax(
          "/autocomplete/search",
          { hint: $(this).val() },
          function (response) {
            console.log(response);
            const data = response.data;
            const courses = data.length >= 5 ? data.slice(0, 4) : data;

            $(".result-search").html("");
            courses.length
              ? $(".search").addClass("show")
              : $(".search").removeClass("show");
            courses.map((course) => {
              const { thumbnail, title, slug } = course;
              $(".result-search").append(`
                                <div class="result-item">
                                    <a href="${
                                      location.origin + "/course/" + slug
                                    }">
                                        <div class="img">
                                            <img src="${
                                              thumbnail.includes("http")
                                                ? thumbnail
                                                : location.origin +
                                                  "/" +
                                                  thumbnail
                                            }" alt="">
                                        </div>
                                        <div class="title">${title}</div>
                                    </a>
                                </div>
                                `);
            });
          }
        );
    });
  });
})();
