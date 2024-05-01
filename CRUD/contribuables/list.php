<div class="card mb-4">
    <div>
        <a class="btn btn-primary" href="index.php?page=Contribuables&action=add">Ajouter un contribuale</a>
    </div>
    <div class="card-header">
        <svg class="svg-inline--fa fa-table me-1" aria-hidden="true" focusable="false" data-prefix="fas"
            data-icon="table" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
            <path fill="currentColor"
                d="M64 256V160H224v96H64zm0 64H224v96H64V320zm224 96V320H448v96H288zM448 256H288V160H448v96zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z">
            </path>
        </svg><!-- <i class="fas fa-table me-1"></i> Font Awesome fontawesome.com -->
        List des contribuables
    </div>


    <div class="card-body">
        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
            <div class="datatable-top">
                <div class="datatable-dropdown">
                    <label>
                        <select class="datatable-selector">
                            <option value="5">5</option>
                            <option value="10" selected="">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                        </select> entries per page
                    </label>
                </div>
                <div class="datatable-search">
                    <input class="datatable-input" id="searchInput" placeholder="Search..." type="search"
                        title="Search within table" aria-controls="datatablesSimple">
                </div>
            </div>
            <div class="datatable-container">
                <table id="contribualesTable" class="datatable-table">
                    <thead>
                        <tr>
                            <th data-sortable="true" style="width: 19.25936599423631%;"><a href="#"
                                    class="datatable-sorter">Identifiant</a></th>
                            <th data-sortable="true" style="width: 8.30835734870317%;"><a href="#"
                                    class="datatable-sorter">CIN</a></th>
                            <th data-sortable="true" style="width: 15.8895292987512%;"><a href="#"
                                    class="datatable-sorter">Nom & Prenom</a></th>
                            <th data-sortable="true" style="width: 14.741594620557157%;"><a href="#"
                                    class="datatable-sorter">Address</a></th>
                            <th data-sortable="true" style="width: 9.505283381364073%;"><a href="#"
                                    class="datatable-sorter">Ville</a></th>
                            <th data-sortable="true" style="width: 15.295869356388089%;"><a href="#"
                                    class="datatable-sorter">Action</a></th>
                        </tr>
                    </thead>
                    <tbody id="contribualesBody">
                        <!-- Contribuales data will be populated here -->
                    </tbody>
                </table>
            </div>
            <div class="datatable-bottom">
                <div class="datatable-info">Showing 1 to 10 of 57 entries</div>
                <nav class="datatable-pagination">
                    <ul id="pagination" class="datatable-pagination-list">
                        <!-- Pagination will be populated here -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const tableBody = document.getElementById('contribualesBody');
        const pagination = document.getElementById('pagination');
        const searchInput = document.getElementById('searchInput');

        // Function to fetch contribuales data from API
        const fetchContribuales = async () => {
            try {
                const response = await fetch('API.php?action=GetContribuales');
                const data = await response.json();
                return data.data; // Return only the contribuales data
            } catch (error) {
                console.error('Error:', error);
                return [];
            }
        };

        // Function to populate table with contribuales data
        const populateTable = async () => {
            const contribuales = await fetchContribuales();

            // Clear existing table data
            tableBody.innerHTML = '';

            // Populate table rows with contribuales data
            contribuales.forEach(contribuale => {
                const row = document.createElement('tr');
                const idCell = document.createElement('td');
                idCell.textContent = contribuale.identifiant;

                const cinCell = document.createElement('td');
                cinCell.textContent = contribuale.CIN;

                const nameCell = document.createElement('td');
                nameCell.textContent = contribuale.fullName;

                const addressCell = document.createElement('td');
                addressCell.textContent = contribuale.address;

                const cityCell = document.createElement('td');
                cityCell.textContent = contribuale.Ville;

                const deleteBtn = document.createElement('button');
                deleteBtn.classList.add('btn', 'btn-danger', 'btn-sm');
                deleteBtn.textContent = 'Supprimer';
                deleteBtn.addEventListener('click', () => {

                    const cin = contribuale.CIN;
                    fetch('API.php', {
                        method: 'DELETE',
                        body: JSON.stringify({
                            action: 'DeleteContribuale',
                            contribualeId: contribuale.CIN
                        })
                    })
                    .then(() => {
                            populateTable();
                        });

                });

                const deleteCell = document.createElement('td');
                deleteCell.appendChild(deleteBtn);

                row.appendChild(idCell);
                row.appendChild(cinCell);
                row.appendChild(nameCell);
                row.appendChild(addressCell);
                row.appendChild(cityCell);
                row.appendChild(deleteCell);

                tableBody.appendChild(row);
            });
        };

        // Initial population of the table
        await populateTable();

        // Search functionality
        searchInput.addEventListener('input', async () => {
            const searchValue = searchInput.value.toLowerCase();
            const filteredContribuales = (await fetchContribuales()).filter(contribuale => {
                return contribuale.identifiant.toLowerCase().includes(searchValue) ||
                    contribuale.CIN.toLowerCase().includes(searchValue) ||
                    contribuale.fullName.toLowerCase().includes(searchValue) ||
                    contribuale.address.toLowerCase().includes(searchValue) ||
                    contribuale.Ville.toLowerCase().includes(searchValue);
            });
            populateTable(filteredContribuales);
        });
    });
</script>