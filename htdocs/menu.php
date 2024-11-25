
<nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="Teams.php">Teams</a></li>
        <li><a href="Player_list.php">View Players</a></li>
        <li><a href="Games.php">Games</a></li>
       
    <ul>
</nav>

<style>
      * {
    margin: 0;
    padding: 0;
    box-sizing: border-box; /* Added for better layout control */
    font-family: 'Arial', sans-serif;
}

body {
    background-color: #f4f4f4; /* Light background for contrast */
    color: #333; /* Dark text for readability */
}

nav {
    background-color: #333;
    overflow: hidden;
    padding: 10px; /* Slightly increased padding for better spacing */
}

nav ul {
    list-style: none;
    display: flex; /* Flexbox for horizontal layout */
    justify-content: center; /* Center the navigation items */
}

nav li {
    margin: 0 15px; /* Added margin for spacing between items */
}

nav a {
    display: block;
    color: white;
    text-align: center;
    padding: 10px 15px; /* Adjusted padding for a more balanced look */
    text-decoration: none;
    border-radius: 5px; /* Rounded corners for buttons */
    transition: background-color 0.3s ease; /* Smooth hover transition */
}

nav a:hover {
    background-color: #ddd;
    color: black;
}

.button {
    border: none;
    color: white;
    padding: 10px 20px; /* Adjusted padding for button size */
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 5px; /* Rounded corners for buttons */
    cursor: pointer; /* Pointer cursor for buttons */
}

.red {
    background-color: #f44336;
}

.green {
    background-color: #04AA6D;
}

h1 {
    margin: 30px 0; /* Top and bottom margin for spacing */
    text-align: center;
    font-size: 2.5em; /* Increased font size for emphasis */
}

.center-table {
    margin: 20px auto; /* Added margin for spacing */
    width: 80%; /* Set a width for the table */
    border-collapse: collapse; /* Clean table borders */
}

th, td {
    padding: 10px;
    border: 1px solid #ccc; /* Light border for table cells */
    text-align: left; /* Align text to the left */
}

th {
    background-color: #333; /* Dark background for headers */
    color: white; /* White text for headers */
}

td {
    background-color: #fff; /* White background for table cells */
}

td:hover {
    background-color: #f9f9f9; /* Light grey background on hover */
}


    </style>