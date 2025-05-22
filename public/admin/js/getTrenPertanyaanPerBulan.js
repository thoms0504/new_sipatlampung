document.addEventListener('DOMContentLoaded', function() {
  // Debug toggle
  document.getElementById('toggle-debug').addEventListener('click', function() {
      var debugArea = document.getElementById('debug-info');
      if (debugArea.style.display === 'none') {
          debugArea.style.display = 'block';
          this.textContent = 'Hide Debug Info';
      } else {
          debugArea.style.display = 'none';
          this.textContent = 'Show Debug Info';
      }
  });

  var ctx = document.getElementById('chart-tren-pertanyaan').getContext('2d');
  var chartTrenPertanyaan;

  // Data awal untuk grafik
  var dataTrenPertanyaan = <?= json_encode($trenPertanyaan) ?>;
  
  // Debug initial data
  document.getElementById('debug-response').innerHTML = 'Initial data: ' + JSON.stringify(dataTrenPertanyaan);

  // Fungsi untuk membuat grafik
  function createChart(labels, data) {
      if (chartTrenPertanyaan) {
          chartTrenPertanyaan.destroy(); // Hancurkan grafik sebelumnya jika ada
      }

      chartTrenPertanyaan = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: labels, // Label bulan (Januari-Desember)
              datasets: [{
                  label: 'Jumlah Pertanyaan',
                  data: data, // Data jumlah pertanyaan
                  backgroundColor: 'rgba(75, 192, 192, 0.2)',
                  borderColor: 'rgba(75, 192, 192, 1)',
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
              },
              animation: {
                  duration: 1000 // Animate changes more visibly
              }
          }
      });
  }

  // Buat grafik pertama kali
  if (dataTrenPertanyaan && dataTrenPertanyaan.labels && dataTrenPertanyaan.data) {
      createChart(dataTrenPertanyaan.labels, dataTrenPertanyaan.data);
  } else {
      console.error('Format data awal tidak valid:', dataTrenPertanyaan);
      document.getElementById('debug-response').innerHTML += '<br>ERROR: Format data awal tidak valid!';
  }

  // Event saat dropdown tahun berubah
  document.getElementById('tahunDropdown').addEventListener('change', function() {
      var tahun = this.value;
      console.log('Tahun yang dipilih:', tahun);
      
      // Update UI untuk tahun yang dipilih
      document.getElementById('selected-year').textContent = tahun;
      
      // URL lengkap dengan base_url
      var requestUrl = '<?= site_url('admin/dasbor/getDataTrenPertanyaan') ?>';
      document.getElementById('debug-request').innerHTML = 'Request URL: ' + requestUrl + '<br>Tahun: ' + tahun;
      
      // Gunakan jQuery AJAX jika tersedia (lebih kompatibel dengan CI)
      if (typeof $ !== 'undefined') {
          $.ajax({
              url: requestUrl,
              method: 'POST',
              data: {
                  tahun: tahun
              },
              dataType: 'json',
              beforeSend: function() {
                  console.log('Mengirim request AJAX ke: ' + requestUrl);
              },
              success: function(data) {
                  console.log('Data yang diterima:', data);
                  document.getElementById('debug-response').innerHTML = 'Response: ' + JSON.stringify(data);
                  
                  if (data && data.labels && data.data) {
                      // Update chart dengan data baru
                      createChart(data.labels, data.data);
                  } else {
                      console.error('Format data tidak valid:', data);
                      document.getElementById('debug-response').innerHTML += '<br>ERROR: Format data tidak valid!';
                  }
              },
              error: function(xhr, status, error) {
                  console.error('AJAX Error:', status, error);
                  document.getElementById('debug-response').innerHTML = 'AJAX Error: ' + status + ' - ' + error + 
                                                                       '<br>Response Text: ' + xhr.responseText;
              }
          });
      } else {
          // Fallback ke Fetch API jika jQuery tidak tersedia
          var formData = new FormData();
          formData.append('tahun', tahun);
          
          // CSRF for CodeIgniter 4 if needed
          <?php if (function_exists('csrf_token') && function_exists('csrf_hash')): ?>
          formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
          <?php endif; ?>
          
          fetch(requestUrl, {
              method: 'POST',
              headers: {
                  'X-Requested-With': 'XMLHttpRequest'
              },
              body: formData
          })
          .then(response => {
              if (!response.ok) {
                  throw new Error('Network response was not ok: ' + response.statusText);
              }
              return response.json();
          })
          .then(data => {
              console.log('Data yang diterima:', data);
              document.getElementById('debug-response').innerHTML = 'Response: ' + JSON.stringify(data);
              
              if (data && data.labels && data.data) {
                  createChart(data.labels, data.data);
              } else {
                  console.error('Format data tidak valid:', data);
                  document.getElementById('debug-response').innerHTML += '<br>ERROR: Format data tidak valid!';
              }
          })
          .catch(error => {
              console.error('Fetch Error:', error);
              document.getElementById('debug-response').innerHTML = 'Fetch Error: ' + error.message;
          });
      }
  });
});