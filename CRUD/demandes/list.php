<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <a href="index.php?page=Demandes&action=add" class="btn btn-primary mb-3">Ajouter une demande</a>
        <h1 class="mb-4">Filtre des demandes</h1>
        <form id="filterForm">
            <div class="form-group">
                <label for="startDate">Start Date:</label>
                <input type="date" class="form-control" id="startDate" name="startDate">
            </div>

            <div class="form-group">
                <label for="endDate">End Date:</label>
                <input type="date" class="form-control" id="endDate" name="endDate">
            </div>

            <div class="form-group">
                <label for="typeCourier">Type Courier:</label>
                <select class="form-control" id="typeCourier" name="typeCourier">
                    <option value="">Select Type Courier</option>
                </select>
            </div>

            <div class="form-group">
                <label for="typeDestination">Type Destination:</label>
                <select class="form-control" id="typeDestination" name="typeDestination">
                    <option value="">Select Type Destination</option>
                </select>
            </div>

            <div class="form-group">
                <label for="typeAttestation">Type Attestation:</label>
                <select class="form-control" id="typeAttestation" name="typeAttestation">
                    <option value="">Select Type Attestation</option>
                </select>
            </div>

            <div class="form-group">
                <label for="CIN">CIN:</label>
                <input type="text" class="form-control" id="CIN" name="CIN">
            </div>

            <button type="button" class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>
        </form>

        <div id="resultContainer" class="mt-5">

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>

        function renderTable(data, container) {
            if (!data || data.length === 0) {
                container.innerHTML = '<p>No data found based on provided filters</p>';
                return;
            }

            const table = `
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>CIN</th>
                    <th>Nom et prenom</th>
                    <th>idantifiant</th>
                    <th>Destination</th>
                    <th>Type Courier</th>
                    <th>Type Attestation</th>
                </tr>
            </thead>
            <tbody>
                ${data.map(row => `
                    <tr>
                        <td>${row.id}</td>
                        <td>${row.date}</td>
                        <td>${row.CIN}</td>
                        <td>${row.fullName}</td>
                        <td>${row.identifiant}</td>
                        <td>${row.destination}</td>
                        <td>${row.typeCourier}</td>
                        <td>${row.typeAttestation}</td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
            container.innerHTML = table;
        }

        async function applyFilters() {
            const formData = new FormData(document.getElementById('filterForm'));
            const data = Object.fromEntries(formData.entries());

            if (data.startDate && data.endDate && data.startDate === data.endDate) {
                const [year, month, day] = data.endDate.split('-').map(Number); // Parse the date string
                const endDate = new Date(year, month - 1, day, 23, 59, 59, 999); // Set to end of day
                data.endDate = endDate.toISOString().split('T')[0]; // Convert to YYYY-MM-DD format
            }


            const response = await fetch('API.php?action=GetReceiptData', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            const resultContainer = document.getElementById('resultContainer');


            renderTable(result, resultContainer);


        }


        async function populateDropdowns() {
            // Populate Type Destination dropdown
            const destinationsResponse = await fetch('API.php?action=GetDestination');
            const destinationsData = await destinationsResponse.json();
            const destinationDropdown = document.getElementById('typeDestination');
            destinationsData.forEach(destination => {
                const option = document.createElement('option');
                option.text = destination.name;
                option.value = destination.name;
                destinationDropdown.add(option);
            });

            // Populate Type Attestation dropdown
            const attestationsResponse = await fetch('API.php?action=GetAttestationType');
            const attestationsData = await attestationsResponse.json();
            const attestationDropdown = document.getElementById('typeAttestation');
            attestationsData.forEach(attestation => {
                const option = document.createElement('option');
                option.text = attestation.name;
                option.value = attestation.name;
                attestationDropdown.add(option);
            });

            // Populate Type Courier dropdown
            const couriersResponse = await fetch('API.php?action=GetTypeCourier');
            const couriersData = await couriersResponse.json();
            const courierDropdown = document.getElementById('typeCourier');
            couriersData.forEach(courier => {
                const option = document.createElement('option');
                option.text = courier.name;
                option.value = courier.name;
                courierDropdown.add(option);
            });
        }

        // Populate dropdowns when the page loads
        populateDropdowns();
    </script>

</body>

</html>