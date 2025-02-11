
  </div>
</div>
<script> 
  const rowsPerPage = 10;
  let currentPage = 1; 
  
  // Function to render the table based on the current page
  function renderTable() {
    const table = document.querySelector('#dataTable tbody');
    const rows = Array.fr om(table.querySelectorAll('tr'));
    
    const startIndex = (currentPage - 1) * rowsPerPage;
    const endIndex = startIndex + rowsPerPage;
    
    // Hide all rows
    rows.forEach(row => row.style.display = 'none');
    
    // Show only the rows for the current page
    rows.slice(startIndex, endIndex).forEach(row => row.style.display = 'table-row');
  }
  
  // Function to render pagination controls
  function renderPagination() {
    const table = document.querySelector('#dataTable tbody');
    const rows = Array.from(table.querySelectorAll('tr'));
    const pageCount = Math.ceil(rows.length / rowsPerPage);
    
    const pagination = document.querySelector('#pagination');
    pagination.innerHTML = '';

    // First button
    const firstButton = document.createElement('li');
    firstButton.classList.add('page-item');
    firstButton.innerHTML = `<a class="page-link" href="#">First</a>`;
    firstButton.addEventListener('click', (e) => {
      e.preventDefault();
      currentPage = 1;
      renderTable();
      renderPagination();
    });
    pagination.appendChild(firstButton);

    // Previous button
    const prevButton = document.createElement('li');
    prevButton.classList.add('page-item');
    prevButton.innerHTML = `<a class="page-link" href="#">Previous</a>`;
    prevButton.addEventListener('click', (e) => {
      e.preventDefault();
      if (currentPage > 1) {
        currentPage--;
        renderTable();
        renderPagination();
      }
    });
    pagination.appendChild(prevButton);

    // Generate the page buttons
    for (let i = 1; i <= pageCount; i++) {
      const li = document.createElement('li');
      li.classList.add('page-item');
      if (i === currentPage) {
        li.classList.add('active');
      }
      const a = document.createElement('a');
      a.classList.add('page-link');
      a.href = '#';
      a.textContent = i;

      a.addEventListener('click', function(event) {
        event.preventDefault();
        currentPage = i;
        renderTable();
        renderPagination();
      });

      li.appendChild(a);
      pagination.appendChild(li);
    }

    // Next button
    const nextButton = document.createElement('li');
    nextButton.classList.add('page-item');
    nextButton.innerHTML = `<a class="page-link" href="#">Next</a>`;
    nextButton.addEventListener('click', (e) => {
      e.preventDefault();
      if (currentPage < pageCount) {
        currentPage++;
        renderTable();
        renderPagination();
      }
    });
    pagination.appendChild(nextButton);

    // Last button
    const lastButton = document.createElement('li');
    lastButton.classList.add('page-item');
    lastButton.innerHTML = `<a class="page-link" href="#">Last</a>`;
    lastButton.addEventListener('click', (e) => {
      e.preventDefault();
      currentPage = pageCount;
      renderTable();
      renderPagination();
    });
    pagination.appendChild(lastButton);
  }
  
  // Initialize the table and pagination
  renderTable();
  renderPagination();
</script>

<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script><script src="dashboard.js"></script></body>
</body>
</html>
