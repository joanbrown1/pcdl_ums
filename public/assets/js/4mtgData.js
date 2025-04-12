// Fetch data from the API
const requestOption = {
  method: "GET",
  redirect: "follow",
};

fetch("http://localhost:3010/proxy/api1", requestOption)
  .then((response) => response.json()) // Parse the response as JSON
  .then((data) => {
    // Step 1: Extract unique zones and groups
    const uniqueZones = new Set();
    const uniqueGroups = new Set();

    // Step 2: Count total registrations
    const totalRegistrations = data.length;

    data.forEach((entry) => {
      if (entry.zonalId) {
        uniqueZones.add(entry.zonalId); // Add zonalId to the Set
      }
      if (entry.groupId && entry.groupId !== "na") {
        uniqueGroups.add(entry.groupId); // Add groupId to the Set (ignore "na")
      }
    });

    // Step 3: Display the counts
    document.getElementById("totalRegistrations").textContent =
      totalRegistrations;
    document.getElementById("uniqueZones").textContent = uniqueZones.size;
    document.getElementById("uniqueGroups").textContent = uniqueGroups.size;

    // Step 4: Display unique zones in a table
    const zonesTableBody = document.querySelector("#zonesTable tbody");
    uniqueZones.forEach((zone) => {
      const row = document.createElement("tr");
      const cell = document.createElement("td");
      cell.textContent = zone;
      row.appendChild(cell);
      zonesTableBody.appendChild(row);
    });

    // Step 5: Display unique groups in a table
    const groupsTableBody = document.querySelector("#groupsTable tbody");
    uniqueGroups.forEach((group) => {
      const row = document.createElement("tr");
      const cell = document.createElement("td");
      cell.textContent = group;
      row.appendChild(cell);
      groupsTableBody.appendChild(row);
    });
  })
  .catch((error) => console.error(error));
