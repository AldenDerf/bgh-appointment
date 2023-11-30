let towns = [
  {
    town: 'Basco',
    barangays: [
      'Kaychanarianan',
      'Kayvaluganan',
      'Kayhuvokan',
      'San Antonion',
      'San Joaquin',
      'Chanarian'
    ]
  },

  {
    town: 'Mahatao',
    barangays: [
      'Hañib',
      'Kaumbakan',
      'Panatayan',
      'Uvoy',
    ]
  },
  {
    town: 'Ivana',
    barangays: [
      'Radiwan',
      'Salagao',
      'Tuhel',
      'San Vicente',

    ]
  },
  {
    town: 'Uyugan',
    barangays: [
      'Kayuganan',
      'Kayvaluganan',
      'Itbud',
      'Imnajbu'
    ]
  },
  {
    town: 'Sabtang',
    barangays: [
      'Malakdang',
      'Sinakan',
      'Savidug',
      'Chavayan',
      'Sumnanga',
      'Nakanmuan',
    ]
  },
  {
    town: 'Itbayat',
    barangays: [
      'Santa Rosa',
      'Santa Maria',
      'Santa Lucia',
      'San Rafael',
      'Raele'

    ]
  }
];

// Function that populate Towns select element
function populateTownSelect(){
    const townSelect = document.getElementById('town-select');
    
 
    // Populate the Towns select element
    towns.forEach(town => {
        const option = document.createElement("option");
        option.textContent = town.town; // Set the text content of the option
        townSelect.appendChild(option);
    });
}



// Function to populate the Baranngays select element base on the selected town
function populateBarangaySelect(selectedTown){
  const barangaySelect = document.getElementById('barangay');
  const selectedTownData = towns.find( town => town.town == selectedTown);

  // Clear previous barangay options
  barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

  if( selectedTownData ){
    selectedTownData.barangays.forEach(barangay => {
      const option = document.createElement('option');
      option.value = barangay;
      option.textContent = barangay;
      barangaySelect.appendChild(option);
    });

    // Enable the Barangay select if a town is selected
    barangaySelect.disabled = false;
  } else {
    // Disable the barangay select if a town is selected
    barangaySelect.disabled = true;
  }
}

// Initially populate the Towns select element
populateTownSelect();

// Event listener to populate Barangays based on the selected town
document.getElementById("town-select").addEventListener("change", function () {
  const selectedTown = this.value;
  populateBarangaySelect(selectedTown);
});

// Initially disable the Barangay Select
// Initially disable the Barangay Select
const barangaySelect = document.getElementById('barangay');
barangaySelect.disabled = true;
