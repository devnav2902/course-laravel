import { ajax } from "./utils.js";
(function () {
  const labels = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  const chart = $("#revenueChart")[0];
  const options = {
    responsive: true,
    maintainAspectRatio: false,

    scales: {
      y: {
        beginAtZero: false,
        display: true,
      },
      x: { title: { display: true, text: "Month" } },
    },
  };
  Chart.defaults.font.size = 18;
  const date = new Date();

  $(".overview-item").on("click", function () {
    const button = $(this);
    const chartName = button.data().chart;

    const chart = $(`canvas#${chartName}`);

    $(".overview-item").each(function (i, e) {
      $(e).removeClass("overview-active");
    });
    button.addClass("overview-active");

    $(".activeChart").each(function (i, e) {
      $(e).removeClass("activeChart");
    });
    chart.parent().addClass("activeChart");

    if (chartCreated(chart)) return false;
    chart.addClass("created");

    if (chartName == "enrollmentsChart") {
      return ajax(
        "/performance/enrollments",
        {
          year: date.getFullYear(),
          currentMonth: date.getMonth() + 1,
        },
        function (response) {
          const data = [...response];

          options.scales.y["ticks"] = {
            stepSize: 2,
          };
          const myChart = new Chart(chart[0], {
            type: "line",
            data: {
              labels: labels,
              datasets: [
                {
                  label: "Enrollments",
                  data: data,
                  fill: false,
                  borderColor: "rgb(75, 192, 192)",
                  tension: 0.1,
                },
              ],
            },
            options: options,
          });
        }
      );
    }

    if (chartName == "ratingChart") {
      return ajax(
        "/performance/rating",
        {
          year: date.getFullYear(),
          currentMonth: date.getMonth() + 1,
        },
        function (response) {
          const data = [...response];

          const ratings = data.map((rating) => {
            const avg = rating.avg_rating
              ? parseFloat(rating.avg_rating).toFixed(1)
              : 0;
            return {
              avg,
              count: rating.count_student,
            };
          });

          const myChart = new Chart(chart[0], {
            type: "bar",
            data: {
              labels: labels,

              datasets: [
                {
                  label: "Average Rating",
                  data: ratings,
                  fill: false,
                  borderColor: "rgb(75, 192, 192)",
                  tension: 0.1,
                },
              ],
            },
            options: {
              scales: {
                y: {
                  max: 5,
                  min: 0,
                  ticks: {
                    stepSize: 1,
                  },
                },
                x: { title: { display: true, text: "Month" } },
              },
              parsing: {
                yAxisKey: "avg",
                xAxisKey: "count",
              },
              plugins: {
                tooltip: {
                  yAlign: "bottom",
                  displayColors: false,
                  callbacks: {
                    title: function (context) {
                      return "";
                    },
                    label: function (context) {
                      const index = context.dataIndex;
                      const value = context.dataset.data[index];

                      return [
                        "Number of rating: " + value.count,
                        "Average Rating: " + value.avg,
                      ];
                    },
                  },
                },
              },
            },
          });
        },
        function (e) {
          console.log(e);
        }
      );
    }

    if (chartName == "coursesChart") {
      return ajax(
        "/performance/courses",
        {
          year: date.getFullYear(),
          currentMonth: date.getMonth() + 1,
        },
        function (response) {
          const data = [...response];
          console.log(data);
          options.scales.y["ticks"] = {
            stepSize: 2,
          };
          const myChart = new Chart(chart[0], {
            type: "line",
            data: {
              labels: labels,
              datasets: [
                {
                  label: "Courses",
                  data: data,
                  fill: false,
                  borderColor: "rgb(75, 192, 192)",
                  tension: 0.1,
                },
              ],
            },
            options: options,
          });
        },
        function (error) {
          console.log(error);
        }
      );
    }
  });

  ajax(
    "/performance/revenue",
    { year: date.getFullYear(), currentMonth: date.getMonth() + 1 },
    function (response) {
      const data = [...response];

      const myChart = new Chart(chart, {
        type: "line",
        data: {
          labels: labels,
          datasets: [
            {
              label: "Revenue",
              data: data,
              fill: false,
              borderColor: "rgb(75, 192, 192)",
              tension: 0.1,
            },
          ],
        },
        options: options,
      });
    }
  );
})();

function chartCreated(element) {
  if (element.hasClass("created")) return true;
  return false;
}
