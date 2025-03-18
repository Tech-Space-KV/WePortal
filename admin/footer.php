
  </div>
</div>


<script>
    const rowsPerPage = 7; // Number of rows per page
    let currentPage = 1;

    const rows = document.querySelectorAll("#dataTable tbody tr"); // All rows in the table
    const totalRows = rows.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage);

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
    }

    // Function to change the current page
    function changePage(direction) {
      currentPage += direction;
      displayTable();
    }

    // Initialize the table on page load
    window.onload = displayTable;
  </script>

<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script><script src="dashboard.js"></script></body>
</body>
</html>
