const fetchMainData = async () => {
  try {
    const response = await fetch("http://localhost:3010/proxy/api1");
    return await response.json();
  } catch (error) {
    console.error("Error fetching main data:", error);
    return [];
  }
};

const fetchZoneData = async () => {
  try {
    const response = await fetch("http://localhost:3010/proxy/api2", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ operation: "zones" }),
    });
    return await response.json();
  } catch (error) {
    console.error("Error fetching zone data:", error);
    return { data: [] };
  }
};

const fetchGroupData = async (zoneId) => {
  try {
    const response = await fetch("http://localhost:3010/proxy/api2", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ operation: "groups", zone_id: zoneId }),
    });
    return await response.json();
  } catch (error) {
    console.error(`Error fetching group data for zone ${zoneId}:`, error);
    return { data: [] };
  }
};

// Main function to fetch all data and render the table
const fetchAndRenderTable = async () => {
  try {
    // Step 1: Fetch main data and zone data in parallel
    const [mainData, zoneData] = await Promise.all([
      fetchMainData(),
      fetchZoneData(),
    ]);

    console.log("Main Data:", mainData);
    console.log("Zone Data:", zoneData);

    // Step 2: Create a mapping for zone names
    const zoneMap = new Map(
      zoneData?.data?.map((zone) => [zone.zone_id, zone.zone_name])
    );

    // Step 3: Extract unique zone IDs from main data
    const uniqueZoneIds = [...new Set(mainData.map((entry) => entry.zonalId))];

    // Step 4: Fetch all group data based on unique zone IDs
    const groupDataResponses = await Promise.all(
      uniqueZoneIds.map((zoneId) => fetchGroupData(zoneId))
    );

    console.log("Group Data Responses:", groupDataResponses);

    // Step 5: Create a mapping for group names
    const groupMap = new Map();
    groupDataResponses.forEach((groupData, index) => {
      if (groupData?.data) {
        groupData.data.forEach((group) => {
          groupMap.set(group.group_id, group.group_name);
        });
      } else {
        console.warn(`No groups found for zone: ${uniqueZoneIds[index]}`);
      }
    });

    console.log("Group Map:", groupMap);

    // Step 6: Populate the table
    const tableBody = document.querySelector("#file-datatable tbody");
    tableBody.innerHTML = "";

    mainData.forEach((entry) => {
      const row = document.createElement("tr");

      row.innerHTML = `
        <td>${entry.email || "N/A"}</td>
        <td>${zoneMap.get(entry.zonalId) || "N/A"}</td>
        <td>${groupMap.get(entry.groupId) || "N/A"}</td>
        <td>${
          entry.timeAdded
            ? new Date(entry.timeAdded * 1000).toLocaleDateString("en-GB")
            : "N/A"
        }</td>
      `;

      tableBody.appendChild(row);
    });
  } catch (error) {
    console.error("Error fetching or rendering data:", error);
  }
};

// Run the function to fetch and display data
fetchAndRenderTable();
