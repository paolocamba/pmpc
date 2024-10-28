<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liaison Dashboard</title>
    <link rel="stylesheet" href="../../css/admin-general.css">
    <link rel="stylesheet" href="../../css/liaison.css"> <!-- Linking CSS -->
</head>
<body>
    <!-- Container for the sidebar and main content -->
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <div class="logo">
                    <img src="../../assets/pmpc-logo.png" alt="PMPC Logo">
                </div>
                <h2 class="pmpc-text">PASCHAL</h2> <!-- Text beside the logo -->
            </div>

            <ul class="sidebar-menu">
                <li><a class="active">Dashboard</a></li>
            </ul>

            <ul class="sidebar-settings">
                <li><a href="admin-settings.html">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Collateral Assessment</h1>
                <button class="logout-button" onclick="redirectToIndex()">Log out</button>
            </header>

            <!-- Collateral Assessment Content -->
            <div class="collateral-assessment-container">
                <div class="collateral-title">
                    <h2>COLLATERAL ASSESSMENT</h2>
                    <div class="collateral-id">ID: 021</div>
                </div>

                <div class="collateral-content">
                    <!-- Land Title Section -->
                    <div class="land-title">
                        <h3>Land Title</h3>
                        <div class="title-image">
                            <img src="../../assets/land-title-placeholder.png" alt="Land Title Image" id="landTitleImage">
                        </div>
                    </div>

                    <!-- Table for Borrower Input, Validator, and Result -->
                    <table class="collateral-table">
                        <tr>
                            <th>Property Detail</th>
                            <th>Borrower Input</th>
                            <th>Validator Input</th>
                            <th>Result</th>
                        </tr>

                        <!-- Square Meters -->
                        <tr>
                            <td>Square Meters</td>
                            <td><input type="text" placeholder="Enter Square Meters" name="borrowerSquareMeters" oninput="calculateTotalValue(); calculateLoanableValue();"></td>
                            <td><input type="text" placeholder="Validate Square Meters" name="validatorSquareMeters" oninput="validateField(this);"></td>
                            <td><input type="text" class="result-box" readonly></td>
                        </tr>

                        <!-- Type of Land -->
                        <tr>
                            <td>Type of Land</td>
                            <td><input type="text" placeholder="Enter Type of Land" name="borrowerLandType" oninput="validateField(this);"></td>
                            <td>
                                <select name="validatorLandType" onchange="calculateEMV(); calculateTotalValue(); calculateLoanableValue(); validateField(this);">
                                    <option value="">Select Type of Land</option>
                                    <option value="Residential">Residential</option>
                                    <option value="Agricultural">Agricultural</option>
                                    <option value="Commercial">Commercial</option>
                                </select>
                            </td>
                            <td><input type="text" class="result-box" readonly></td>
                        </tr>

                        <!-- Location -->
                        <tr>
                            <td>Location</td>
                            <td><input type="text" placeholder="Enter Location" name="borrowerLocation" oninput="validateField(this);"></td>
                            <td>
                                <select name="validatorLocation" onchange="calculateEMV(); calculateTotalValue(); calculateLoanableValue(); validateField(this);">
                                    <option value="">Select Location</option>
                                    <option value="Bagbaguin">Bagbaguin</option>
                                    <option value="Bagong Barrio">Bagong Barrio</option>
                                    <option value="Baka-bakahan">Baka-bakahan</option>
                                    <option value="Bunsuran I">Bunsuran I</option>
                                    <option value="Bunsuran II">Bunsuran II</option>
                                    <option value="Bunsuran III">Bunsuran III</option>
                                    <option value="Cacarong Bata">Cacarong Bata</option>
                                    <option value="Cacarong Matanda">Cacarong Matanda</option>
                                    <option value="Cupang">Cupang</option>
                                    <option value="Malibong Bata">Malibong Bata</option>
                                    <option value="Malibong Matanda">Malibong Matanda</option>
                                    <option value="Manatal">Manatal</option>
                                    <option value="Mapulang Lupa">Mapulang Lupa</option>
                                    <option value="Masagana">Masagana</option>
                                    <option value="Masuso">Masuso</option>
                                    <option value="Pinagkuartelan">Pinagkuartelan</option>
                                    <option value="Poblacion">Poblacion</option>
                                    <option value="Real de Cacarong">Real de Cacarong</option>
                                    <option value="San Roque">San Roque</option>
                                    <option value="Santo Niño">Santo Niño</option>
                                    <option value="Siling Bata">Siling Bata</option>
                                    <option value="Siling Matanda">Siling Matanda</option>
                                </select>
                            </td>
                            <td><input type="text" class="result-box" readonly></td>
                        </tr>

                        <!-- Right of Way -->
                        <tr>
                            <td>Right of Way</td>
                            <td><input type="text" placeholder="Enter Right of Way" name="borrowerRightOfWay" oninput="validateField(this)"></td>
                            <td>
                                <select name="validatorRightOfWay" onchange="validateField(this)">
                                    <option value="">Select Right of Way</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                            <td><input type="text" class="result-box" readonly></td>
                        </tr>

                        <!-- Commodities (Hospital, Clinics, etc.) -->
                        <tr>
                            <td>Hospital Proximity</td>
                            <td><input type="text" placeholder="Enter Yes/No" name="borrowerHospital" oninput="validateCommodity(this)"></td>
                            <td>
                                <select name="validatorHospital" onchange="validateCommodity(this)">
                                    <option value="">Select Distance</option>
                                    <option value="<1km">&lt;1km</option>
                                    <option value=">1km">&gt;1km</option>
                                </select>
                            </td>
                            <td><input type="text" class="result-box" readonly></td>
                        </tr>
                        <tr>
                            <td>Clinics Proximity</td>
                            <td><input type="text" placeholder="Enter Yes/No" name="borrowerClinics" oninput="validateCommodity(this)"></td>
                            <td>
                                <select name="validatorClinics" onchange="validateCommodity(this)">
                                    <option value="">Select Distance</option>
                                    <option value="<1km">&lt;1km</option>
                                    <option value=">1km">&gt;1km</option>
                                </select>
                            </td>
                            <td><input type="text" class="result-box" readonly></td>
                        </tr>
                        <tr>
                            <td>School Proximity</td>
                            <td><input type="text" placeholder="Enter Yes/No" name="borrowerSchool" oninput="validateCommodity(this)"></td>
                            <td>
                                <select name="validatorSchool" onchange="validateCommodity(this)">
                                    <option value="">Select Distance</option>
                                    <option value="<1km">&lt;1km</option>
                                    <option value=">1km">&gt;1km</option>
                                </select>
                            </td>
                            <td><input type="text" class="result-box" readonly></td>
                        </tr>
                        <tr>
                            <td>Market Proximity</td>
                            <td><input type="text" placeholder="Enter Yes/No" name="borrowerMarket" oninput="validateCommodity(this)"></td>
                            <td>
                                <select name="validatorMarket" onchange="validateCommodity(this)">
                                    <option value="">Select Distance</option>
                                    <option value="<1km">&lt;1km</option>
                                    <option value=">1km">&gt;1km</option>
                                </select>
                            </td>
                            <td><input type="text" class="result-box" readonly></td>
                        </tr>
                        <tr>
                            <td>Church Proximity</td>
                            <td><input type="text" placeholder="Enter Yes/No" name="borrowerChurch" oninput="validateCommodity(this)"></td>
                            <td>
                                <select name="validatorChurch" onchange="validateCommodity(this)">
                                    <option value="">Select Distance</option>
                                    <option value="<1km">&lt;1km</option>
                                    <option value=">1km">&gt;1km</option>
                                </select>
                            </td>
                            <td><input type="text" class="result-box" readonly></td>
                        </tr>
                        <tr>
                            <td>Public Terminals Proximity</td>
                            <td><input type="text" placeholder="Enter Yes/No" name="borrowerTerminals" oninput="validateCommodity(this)"></td>
                            <td>
                                <select name="validatorTerminals" onchange="validateCommodity(this)">
                                    <option value="">Select Distance</option>
                                    <option value="<1km">&lt;1km</option>
                                    <option value=">1km">&gt;1km</option>
                                </select>
                            </td>
                            <td><input type="text" class="result-box" readonly></td>
                        </tr>
                    </table>

                    <!-- Values Section -->
                    <div class="values-section">
                        <div class="value-inputs">
                            <label for="emv">EMV (Per Sqm):</label>
                            <input type="text" id="emv" name="emv" class="value-input" readonly>
                            
                            <label for="totalValue">Total Value:</label>
                            <input type="text" id="totalValue" name="totalValue" class="value-input" readonly>
                            
                            <label for="loanableValue">Loanable Value:</label>
                            <input type="text" id="loanableValue" name="loanableValue" class="value-input" readonly>
                        </div>
                        <div class="comments-section">
                            <textarea placeholder="Comments"></textarea>
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="file-upload-section">
                        <label for="propertyImage">Upload Property Images:</label>
                        <input type="file" id="propertyImage" accept="image/*" multiple onchange="previewImage(event)"> <!-- Allow multiple uploads -->
                        <div id="imagePreviewContainer">
                            <!-- Uploaded images will be displayed here -->
                        </div>
                    </div>

                    <div class="submit-container">
                        <button class="submit-btn">Submit</button>
                    </div>
                </div>
            </div>
            <!-- End of Collateral Assessment Content -->
        </div>
    </div>

    <script>
        // Define the prices based on location and type of land
        const landPrices = {
            "Bagbaguin": { Residential: 2000, Commercial: 4000, Agricultural: 1100 },
            "Bagong Barrio": { Residential: 2000, Commercial: 4000, Agricultural: 1100 },
            "Baka-bakahan": { Residential: 2000, Commercial: 4000, Agricultural: 1100 },
            "Bunsuran I": { Residential: 2500, Commercial: 5000, Agricultural: 1200 },
            "Bunsuran II": { Residential: 2500, Commercial: 5000, Agricultural: 1200 },
            "Bunsuran III": { Residential: 2500, Commercial: 5000, Agricultural: 1200 },
            "Cacarong Bata": { Residential: 2000, Commercial: 4000, Agricultural: 1200 },
            "Cacarong Matanda": { Residential: 2000, Commercial: 4000, Agricultural: 1200 },
            "Cupang": { Residential: 2000, Commercial: 4000, Agricultural: 1200 },
            "Malibong Bata": { Residential: 2000, Commercial: 4000, Agricultural: 1200 },
            "Malibong Matanda": { Residential: 2000, Commercial: 4000, Agricultural: 1200 },
            "Mapulang Lupa": { Residential: 2500, Commercial: 5000, Agricultural: 1200 },
            "Manatal": { Residential: 2000, Commercial: 4000, Agricultural: 1200 },
            "Masagana": { Residential: 2000, Commercial: 4000, Agricultural: 1200 },
            "Masuso": { Residential: 2500, Commercial: 5000, Agricultural: 800 },
            "Pinagkuartelan": { Residential: 2500, Commercial: 5000, Agricultural: 1200 },
            "Poblacion": { Residential: 3000, Commercial: 6000, Agricultural: 1200 },
            "Real de Cacarong": { Residential: 2000, Commercial: 4000, Agricultural: 1200 },
            "Siling Bata": { Residential: 2500, Commercial: 5000, Agricultural: 1200 },
            "Siling Matanda": { Residential: 2500, Commercial: 5000, Agricultural: 1200 },
            "San Roque": { Residential: 2500, Commercial: 5000, Agricultural: 1200 },
            "Santo Niño": { Residential: 2000, Commercial: 3000, Agricultural: 1200 }
        };

        // Function to calculate EMV
        function calculateEMV() {
            const landType = document.querySelector('select[name="validatorLandType"]').value;
            const location = document.querySelector('select[name="validatorLocation"]').value;

            if (landType && location) {
                const price = landPrices[location][landType];
                const emvInput = document.querySelector('input[name="emv"]');
                
                if (price) {
                    emvInput.value = price; // Set the EMV based on selected values
                } else {
                    emvInput.value = ""; // Reset if no price found
                }
            }
        }

        // Function to calculate Total Value
        function calculateTotalValue() {
            const sqmInput = document.querySelector('input[name="borrowerSquareMeters"]').value;
            const emvInput = document.querySelector('input[name="emv"]').value;

            const totalValueInput = document.querySelector('input[name="totalValue"]');

            if (sqmInput && emvInput) {
                const totalValue = sqmInput * emvInput; // Calculate Total Value
                totalValueInput.value = totalValue; // Set the Total Value
            } else {
                totalValueInput.value = ""; // Reset if either input is empty
            }
        }

        // Function to calculate Loanable Value
        function calculateLoanableValue() {
            const totalValueInput = document.querySelector('input[name="totalValue"]').value;
            const loanableValueInput = document.querySelector('input[name="loanableValue"]');

            if (totalValueInput) {
                const loanableValue = totalValueInput * 0.5; // Calculate Loanable Value as 50% of Total Value
                loanableValueInput.value = loanableValue; // Set the Loanable Value
            } else {
                loanableValueInput.value = ""; // Reset if total value is empty
            }
        }

        // Add event listeners for changes
        document.querySelector('select[name="validatorLandType"]').addEventListener('change', () => {
            calculateEMV();
            calculateTotalValue();
            calculateLoanableValue();
        });
        document.querySelector('select[name="validatorLocation"]').addEventListener('change', () => {
            calculateEMV();
            calculateTotalValue();
            calculateLoanableValue();
        });

        // Existing validateField and validateCommodity functions
        function validateField(inputField) {
            const row = inputField.closest('tr'); // Get the current row
            const borrowerInput = row.querySelector('td:nth-child(2) input').value; // Borrower Input
            const validatorInput = row.querySelector('td:nth-child(3) input, td:nth-child(3) select').value; // Validator Input (considering both input and select)
            const resultBox = row.querySelector('.result-box'); // Result box

            // Check if validating square meters
            if (row.cells[0].textContent === "Square Meters") {
                if (borrowerInput && validatorInput) {
                    const isMatched = borrowerInput === validatorInput;
                    resultBox.value = isMatched ? "Matched" : "Not Matched";
                    resultBox.style.backgroundColor = isMatched ? "#4CAF50" : "#e57373"; // Color based on match
                } else {
                    resultBox.style.backgroundColor = "#ffffff"; // Reset to default white
                    resultBox.value = "";
                }
            } else {
                // For other fields
                if (borrowerInput && validatorInput) {
                    const isMatched = borrowerInput === validatorInput;
                    resultBox.value = isMatched ? "Matched" : "Not Matched";
                    resultBox.style.backgroundColor = isMatched ? "#4CAF50" : "#e57373"; // Color based on match
                } else {
                    resultBox.style.backgroundColor = "#ffffff"; // Reset to default white
                    resultBox.value = "";
                }
            }

            // Update the square meters result with land type and location
            if (row.cells[0].textContent === "Location") {
                const landType = document.querySelector('select[name="validatorLandType"]').value;
                const location = validatorInput; // Use the validator input for location
                const sqmResultBox = document.querySelector('tr:nth-child(1) td:nth-child(4) input'); // Get the result box for square meters
                sqmResultBox.value = `${landType} in ${location}`;
            }
        }

        function validateCommodity(inputField) {
            const row = inputField.closest('tr'); // Get the current row
            const borrowerInput = row.querySelector('td:nth-child(2) input').value.trim().toLowerCase(); // Borrower Input (yes/no)
            const validatorInput = row.querySelector('td:nth-child(3) select').value; // Validator Input (<1km or >1km)
            const resultBox = row.querySelector('.result-box'); // Result box

            if (borrowerInput && validatorInput) {
                // If borrower says 'yes' and validator selects '<1km', it's matched
                if ((borrowerInput === 'yes' && validatorInput === '<1km') || (borrowerInput === 'no' && validatorInput === '>1km')) {
                    resultBox.style.backgroundColor = "#4CAF50"; // Green for matched
                    resultBox.value = "Matched";
                } else {
                    resultBox.style.backgroundColor = "#e57373"; // Red for not matched
                    resultBox.value = "Not Matched";
                }
            } else {
                resultBox.style.backgroundColor = "#ffffff"; // Reset to default white
                resultBox.value = "";
            }
        }

        // Function to preview uploaded images
        function previewImage(event) {
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const files = event.target.files; // Get uploaded files
            
            // Loop through each file and create an image preview
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = function (e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('image-preview'); // Add a class for styling

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '400px'; // Set width of the image to make it bigger
                    img.style.height = 'auto'; // Maintain aspect ratio

                    const deleteBtn = document.createElement('button');
                    deleteBtn.innerHTML = 'X'; // Delete button text
                    deleteBtn.classList.add('delete-btn'); // Add class for styling
                    deleteBtn.onclick = function() {
                        imgContainer.remove(); // Remove image preview on delete
                    };

                    imgContainer.appendChild(img); // Append image to container
                    imgContainer.appendChild(deleteBtn); // Append delete button to container
                    imagePreviewContainer.appendChild(imgContainer); // Append image container to preview area
                };
                reader.readAsDataURL(file); // Read file as data URL
            }
        }
    </script>
</body>
</html>