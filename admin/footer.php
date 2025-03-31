
  </div>
</div>

<script>
    const rowsPerPage = 7; // Number of rows per page
    let currentPage = 1;

    const rows = document.querySelectorAll("#dataTable tbody tr"); // All rows in the table
    const totalRows = rows.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage);
    const paginationContainer = document.getElementById("pagination");

    // Function to display the rows for the current page
    function displayTable() {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        // Hide all rows
        rows.forEach(row => row.style.display = 'none');
        
        // Show rows for the current page
        for (let i = start; i < end && i < totalRows; i++) {
            rows[i].style.display = '';
        }

        // Update pagination buttons
        document.getElementById("prevBtn").disabled = currentPage === 1;
        document.getElementById("nextBtn").disabled = currentPage === totalPages;

        updatePagination();
    }

    // Function to update pagination buttons
    function updatePagination() {
        paginationContainer.innerHTML = '';

        // First button
        const firstBtn = document.createElement("li");
        firstBtn.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        firstBtn.innerHTML = `<a class="page-link" href="#" onclick="goToPage(1)">First</a>`;
        paginationContainer.appendChild(firstBtn);

        // Previous button
        const prevBtn = document.createElement("li");
        prevBtn.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevBtn.innerHTML = `<a class="page-link" href="#" onclick="changePage(-1)">Prev</a>`;
        paginationContainer.appendChild(prevBtn);

        // Page number buttons (showing 5 pages at a time)
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, currentPage + 2);
        
        for (let i = startPage; i <= endPage; i++) {
            const pageBtn = document.createElement("li");
            pageBtn.className = `page-item ${i === currentPage ? 'active' : ''}`;
            pageBtn.innerHTML = `<a class="page-link" href="#" onclick="goToPage(${i})">${i}</a>`;
            paginationContainer.appendChild(pageBtn);
        }

        // Next button
        const nextBtn = document.createElement("li");
        nextBtn.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        nextBtn.innerHTML = `<a class="page-link" href="#" onclick="changePage(1)">Next</a>`;
        paginationContainer.appendChild(nextBtn);

        // Last button
        const lastBtn = document.createElement("li");
        lastBtn.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        lastBtn.innerHTML = `<a class="page-link" href="#" onclick="goToPage(${totalPages})">Last</a>`;
        paginationContainer.appendChild(lastBtn);
    }

    // Function to change the current page
    function changePage(direction) {
        if ((direction === -1 && currentPage > 1) || (direction === 1 && currentPage < totalPages)) {
            currentPage += direction;
            displayTable();
        }
    }

    // Function to jump to a specific page
    function goToPage(page) {
        currentPage = page;
        displayTable();
    }

    // Initialize the table on page load
    window.onload = displayTable;
</script>


<script>
function searchTable() {
    let input = document.getElementById("tableSearch").value.toLowerCase();
    let table = document.getElementById("dataTable");
    let rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
        let cells = rows[i].getElementsByTagName("td");
        let rowContainsSearchTerm = false;

        for (let cell of cells) {
            if (cell.innerText.toLowerCase().includes(input)) {
                rowContainsSearchTerm = true;
                break;
            }
        }

        rows[i].style.display = rowContainsSearchTerm ? "" : "none";
    }
}
</script>


<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script><script src="dashboard.js"></script></body>
</body>
</html>
