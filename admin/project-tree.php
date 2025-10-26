<?php require('header.php');
?>

<link rel="icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  /* --- GENERAL STYLING --- */
  .tree-container {
    position: relative;
    overflow: hidden;
    width: 100%;
    max-width: 150rem;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  /* .tree-scroll {
            overflow-x: auto;
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        } */

  .tree-scroll {
    overflow: auto;
    width: 100%;
    height: 80vh;
    padding: 10px;
    box-sizing: border-box;
    background-color: #fff;
    position: relative;
    scrollbar-width: none;
  }

  /* .tree {
    display: flex;
    justify-content: center;
    flex-direction: column;
    min-width: max-content;
  } */

  .tree {
    display: flex;
    justify-content: flex-start;
    /* ✅ Start from top-left */
    align-items: flex-start;
    /* ✅ Align to top */
    flex-direction: column;
    transform-origin: top left;
    /* ✅ Zoom from top-left */
    min-width: max-content;
  }

  /* --- HORIZONTAL TREE STRUCTURE (DEFAULT) --- */
  .tree ul {
    padding-top: 20px;
    position: relative;
    display: none;
    justify-content: center;
    transition: all 0.3s ease;
  }

  .tree ul.active {
    display: flex;
    flex-wrap: wrap;
  }

  .tree li {
    list-style-type: none;
    text-align: center;
    position: relative;
    padding: 20px 5px 0 5px;
  }

  /* Connector cleanup for horizontal nodes */
  .tree li:only-child::after,
  .tree li:only-child::before {
    display: none
  }

  /* Using border-top: 0 is more precise than border: none */
  .tree li:first-child::before,
  .tree li:last-child::after {
    border-top: 0;
  }

  .tree ul ul li::before,
  .tree ul ul li:last-child::before {
    border-top: 2px solid #ccc;
  }

  .tree ul ul li:first-child::before,
  .tree ul ul li:last-child::after {
    border-top: 0;
    border: 1px solid #ccc;
    width: 0px;
  }

  /* Default horizontal connectors */
  .tree li::before,
  .tree li::after {
    content: '';
    position: absolute;
    top: 0;
    right: 50%;
    border-top: 2px solid #ccc;
    width: 50%;
    height: 20px;
  }

  .tree li::after {
    right: auto;
    left: 50%;
  }

  /* Vertical drop-down line from parent */
  .tree li>ul::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    border-left: 2px solid #ccc;
    width: 0;
    height: 20px;
  }

  /* Connector cleanup for horizontal nodes */
  .tree li:only-child::after,
  .tree li:only-child::before {
    display: none;
  }

  .tree li:first-child::before,
  .tree li:last-child::after {
    border: none;
  }

  /* --- VERTICAL TRANSACTION LIST OVERRIDES --- */

  /* Identify transaction lists and force a vertical column layout */
  .transaction-list.active {
    flex-direction: column;
    align-items: flex-start;
    /* Align items to the left */
    justify-content: flex-start;
    padding-left: 50.75%;
    /* Indent the list from the parent's center */
  }

  /* Style each vertical transaction item */
  .transaction-list>li {
    padding: 10px 0 0 26px;
    /* Adjust padding for the connector line */
    text-align: left;
  }

  /* Hide the default horizontal connectors for transaction items */
  .transaction-list>li::before,
  .transaction-list>li::after {
    display: none;
  }

  /* Create the new vertical connector lines */
  .transaction-list>li::before {
    content: '';
    position: absolute;
    display: block;
    left: 0;
    /* Start from the edge of the padding */
    top: -10px;
    width: 0;
    height: calc(100% + 10px);
    border-left: 2px solid #ccc;
    /* This is the main vertical stem */
  }

  .transaction-list>li::after {
    content: '';
    position: absolute;
    display: block;
    left: 0;
    top: 22px;
    /* Vertically align with the node text */
    width: 25px;
    /* This is the horizontal line to the stem */
    height: 0;
    border-top: 2px solid #ccc;
  }

  /* Adjust the drop-down line for the parent "Activity" node */
  .tree li>ul.transaction-list::before {
    left: calc(50% + 1px);
  }

  /* Ensure the last item's line connects properly */
  .transaction-list>li:last-child:not(.show-more-li)::before {
    height: 32px;
  }

  /* Align the "Show More" button with transaction items */
  .show-more-transaction {
    margin-left: 35px;
  }

  /* --- NODE & MISC STYLING (Unchanged) --- */
  .tree span {
    display: inline-block;
    padding: 10px 20px;
    border: 2px solid #333;
    border-radius: 5px;
    background-color: #fff;
    font-weight: bold;
    cursor: pointer;
    white-space: nowrap;
    transition: background 0.3s, transform 0.2s;
  }

  .tree span:hover {
    background: #eef4ff;
    transform: scale(1.03);
  }

  .level-1 {
    background: #8f9fc0;
    color: #d81515;
  }

  .level-2 {
    background: #bbc3da;
    color: #000;
  }

  .level-3 {
    background: #ffffff;
    color: #000;
    border: 2px solid #333;
  }

  .level-4 {
    background: #f29f05;
    color: #5e0e0e;
  }

  .level-5 {
    background: #c28920;
    color: #c52828;
  }

  .caret::after {
    content: "▶";
    font-size: 12px;
    margin-left: 8px;
    display: inline-block;
    transition: transform 0.3s ease;
  }

  .caret.expanded::after {
    transform: rotate(90deg);
    content: "▼";
  }

  .show-more-transaction {
    background: #8f9fc0;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 12px;
    font-weight: bold;
    margin-top: 10px;
  }

  .show-more-transaction:hover {
    background: #6f82a0;
  }

  .fade-bottom {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 80px;
    background: linear-gradient(to bottom, transparent, #fff);
    pointer-events: none;
  }

  .tree-scroll::-webkit-scrollbar {
    display: none;
  }

  .tree-scroll::-webkit-scrollbar-thumb {
    background: #a5b3d1;
    border-radius: 4px;
  }
</style>

<style>
  #zoomIn,
  #zoomOut {
    background-color: #0D6efd;
    color: #fff;
    border: none;
    transition: background 0.3s;
  }

  #zoomIn:hover,
  #zoomOut:hover {
    background-color: #6f82a0;
  }
</style>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Project Structure</h1>
  </div>

  <div class="d-flex justify-content-end mb-2">
    <button id="zoomOut" class="btn btn-sm btn-secondary me-1"><i class="fa fa-minus"></i></button>
    <button id="zoomIn" class="btn btn-sm btn-secondary"><i class="fa fa-plus"></i></button>
  </div>


  <div class="tree-container">
    <div class="tree-scroll">
      <div class="tree">
        <ul class="active">

          <?php

          $projid = $_GET['project_key'];
          $sqlqry = "select * from `project_list` where `plist_id` = '" . $projid . "' limit 1";
          $result = mysqli_query($con, $sqlqry);
          while ($row = mysqli_fetch_assoc($result)) {
            ?>

            <li><span class="caret level-1">Project: <?php echo $row['plist_title']; ?></span>
              <ul>

                <?php
                $sqlqry1 = "select * from `project_scope` where `pscope_project_id` = '" . $row['plist_id'] . "' ";
                $result1 = mysqli_query($con, $sqlqry1);
                while ($row1 = mysqli_fetch_assoc($result1)) {
                  ?>

                  <li><span class="caret level-2"><?php echo $row1['pscope_state']; ?></span>
                    <ul>

                      <?php
                      $sqlqry2 = "select * from `project_planner` where pplnr_scope_id  = " . $row1['pscope_id'] . " ";
                      $result2 = mysqli_query($con, $sqlqry2);
                      while ($row2 = mysqli_fetch_assoc($result2)) {
                        ?>

                        <li><span class="caret level-3"><?php echo $row2['pplnr_milestone']; ?></span>
                          <ul>

                            <?php
                            $sqlqry3 = "select * from `project_planner_tasks` where pptasks_planner_id  = " . $row2['pplnr_id'] . " ";
                            $result3 = mysqli_query($con, $sqlqry3);
                            while ($row3 = mysqli_fetch_assoc($result3)) {
                              ?>

                              <li><span class="level-4"><?php echo $row3['pptasks_task_title']; ?></span></li>
                              <!-- <li><span class="level-4">Transaction 2</span></li>
                                            <li><span class="level-4">Transaction 3</span></li>
                                            <li><span class="level-4">Transaction 4</span></li>
                                            <li><span class="level-4">Transaction 5</span></li>
                                            <li><span class="level-4">Transaction 6</span></li>
                                            <li><span class="level-4">Transaction 7</span></li>
                                            <li><span class="level-4">Transaction 8</span></li>
                                            <li><span class="level-4">Transaction 9</span></li> -->
                            <?php } ?>
                          </ul>
                        <?php } ?>
                      </li>
                      <!-- <li><span class="caret level-3">Activity 2</span>
                                        <ul>
                                            <li><span class="level-4">Transaction A</span></li>
                                            <li><span class="level-4">Transaction B</span></li>
                                        </ul>
                                    </li> -->
                    </ul>
                  </li>
                  <!-- <li><span class="caret level-2">Project B</span>
                                <ul>
                                    <li><span class="caret level-3">Activity 3</span>
                                        <ul>
                                            <li><span class="level-4">Transaction 1</span></li>
                                            <li><span class="level-4">Transaction 2</span></li>
                                            <li><span class="level-4">Transaction 3</span></li>
                                            <li><span class="level-4">Transaction 4</span></li>
                                            <li><span class="level-4">Transaction 5</span></li>
                                            <li><span class="level-4">Transaction 6</span></li>
                                            <li><span class="level-4">Transaction 7</span></li>
                                            <li><span class="level-4">Transaction 8</span></li>
                                            <li><span class="level-4">Transaction 9</span></li>
                                            <li><span class="level-4">Transaction 10</span></li>
                                            <li><span class="level-4">Transaction 11</span></li>
                                            <li><span class="level-4">Transaction 12</span></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li> -->
                  <!-- <li><span class="caret level-2">Project C</span>
                                <ul>
                                    <li><span class="caret level-3">Activity 4</span>
                                        <ul>
                                            <li><span class="level-4">Transaction 1</span></li>
                                            <li><span class="level-4">Transaction 2</span></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li> -->
                <?php } ?>
              </ul>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="fade-bottom"></div>
  </div>

</main>

<script>
  document.querySelectorAll('.caret').forEach(node => {
    node.addEventListener('click', function (e) {
      e.stopPropagation();
      const childUl = this.parentElement.querySelector(':scope > ul');
      if (childUl) {
        childUl.classList.toggle('active');
        this.classList.toggle('expanded');
      }
    });
  });

  document.querySelectorAll('.level-3').forEach(activity => {
    const transactionList = activity.parentElement.querySelector(':scope > ul');
    if (!transactionList) return;

    transactionList.classList.add('transaction-list');
    const transactions = transactionList.querySelectorAll(':scope > li');

    if (transactions.length > 5) {
      let currentlyVisible = 5;
      for (let i = currentlyVisible; i < transactions.length; i++) {
        transactions[i].style.display = 'none';
      }

      const showBtn = document.createElement('button');
      showBtn.textContent = 'Show More ▼';
      showBtn.className = 'show-more-transaction';

      showBtn.addEventListener('click', () => {
        const showNextCount = currentlyVisible + 5;
        for (let i = currentlyVisible; i < showNextCount && i < transactions.length; i++) {
          transactions[i].style.display = 'list-item';
        }
        currentlyVisible = showNextCount;
        if (currentlyVisible >= transactions.length) {
          showBtn.remove();
        }
      });
      transactionList.appendChild(showBtn);
    }
  });
</script>

<script>
  let scale = 1;
  const tree = document.querySelector('.tree');
  const main = document.querySelector('main');

  document.getElementById('zoomIn').addEventListener('click', () => {
    scale += 0.1;
    tree.style.transform = `scale(${scale})`;
  });

  document.getElementById('zoomOut').addEventListener('click', () => {
    scale = Math.max(0.2, scale - 0.1);
    tree.style.transform = `scale(${scale})`;
  });

  // Optional: zoom with Ctrl + mouse wheel
  main.addEventListener('wheel', e => {
    if (e.ctrlKey) {
      e.preventDefault();
      scale += e.deltaY * -0.001;
      scale = Math.min(Math.max(.2, scale), 3);
      tree.style.transform = `scale(${scale})`;
    }
  });
</script>



<?php require('footer.php'); ?>