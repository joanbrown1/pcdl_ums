// Fetch data from the API
const requestOptions = {
  method: "GET",
  redirect: "follow",
};

fetch(USERS_ROUTE, requestOptions) // Use Laravel route dynamically
  .then((response) => response.json()) // Parse the response as JSON
  .then((data) => {
    console.log("Fetched Data:", data);
    // Step 1: Process the data
    const dateCounts = {};
    data.forEach((entry) => {
      const date = new Date(entry.timeAdded * 1000).toISOString().split("T")[0]; // Convert to YYYY-MM-DD
      dateCounts[date] = (dateCounts[date] || 0) + 1;
    });

    // Step 2: Sort dates and calculate cumulative counts
    const sortedDates = Object.keys(dateCounts).sort();
    const cumulativeCounts = [];
    let cumulativeSum = 0;
    sortedDates.forEach((date) => {
      cumulativeSum += dateCounts[date];
      cumulativeCounts.push(cumulativeSum);
    });

    // Step 3: Format dates to display only month and day (MM-DD)
    const formattedDates = sortedDates.map((date) => {
      const [year, month, day] = date.split("-");
      return `${month}-${day}`; // Format as MM-DD
    });

    // Step 4: Calculate dynamic y-axis range
    const maxValue = Math.max(...cumulativeCounts);
    const padding = maxValue * 0.1; // Add 10% padding
    const suggestedMax = maxValue + padding;

    // Step 5: Render the Chart.js line chart
    const myCanvas = document.getElementById("4mtgc");
    const myCanvasContext = myCanvas.getContext("2d");

    // Gradient for the line
    const gradientStroke = myCanvasContext.createLinearGradient(0, 80, 0, 280);
    gradientStroke.addColorStop(0, "rgba(108, 95, 252, 0.8)");
    gradientStroke.addColorStop(1, "rgba(108, 95, 252, 0.2)");

    document.getElementById("4mtgc").innerHTML = "";
    const myChart = new Chart(myCanvas, {
      type: "line", // Use a line chart
      data: {
        labels: formattedDates, // Use formatted dates (MM-DD) on the x-axis
        datasets: [
          {
            label: "Cumulative Number of Registrations",
            data: cumulativeCounts, // Cumulative counts on the y-axis
            backgroundColor: gradientStroke,
            borderColor: "rgba(108, 95, 252, 1)",
            borderWidth: 2,
            fill: true, // Fill the area under the line
            tension: 0.4, // Smooth line
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true,
          },
          tooltip: {
            enabled: true,
            callbacks: {
              title: (context) => {
                // Display full date (YYYY-MM-DD) in tooltip
                const index = context[0].dataIndex;
                return sortedDates[index];
              },
            },
          },
        },
        scales: {
          x: {
            ticks: {
              color: "#b0bac9",
            },
            grid: {
              display: false,
            },
          },
          y: {
            beginAtZero: true, // Start the y-axis at 0
            suggestedMin: 0, // Ensure the y-axis starts at 0
            suggestedMax: suggestedMax, // Use dynamic padding
            grid: {
              color: "rgba(142, 156, 173, 0.1)",
            },
            ticks: {
              color: "#b0bac9",
              stepSize: Math.ceil(suggestedMax / 10), // Dynamic step size
            },
          },
        },
      },
    });
  })
  .catch((error) => console.error("Error fetching data:", error));
