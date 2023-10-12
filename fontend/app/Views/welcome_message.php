<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url('css/output.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('select2/css/select2.min.css'); ?>" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <div class="bg-cyan-600 fixed w-full">
        <nav class="flex justify-between max-w-7xl mx-auto py-4 px-2 z-[999999]">
            <div class="w-28">
                <img src="https://pitjarus.com/assets/images/logo_pitjarus_2020_10th%20(1).png">
            </div>
            <button class="text-white">
                Hello, M. Hanafi
            </button>
        </nav>
    </div>
    <div class="pt-20 px-2 max-w-7xl mx-auto">
        <div class="flex justify-between items-center">
            <div>
                <label for="area" class="mb-1">Pilih Area</label>
                <select name="area" id="area" class="w-full px-2 py-2 border rounded-md outline-none select2" multiple>
                    <option value="">--Pilih Area--</option>
                </select>
            </div>
            <div>
                <label for="from" class="mb-1">Select Date From</label>
                <input type="date" name="from" id="from" class="w-full px-2 py-1 border rounded-md outline-none">
            </div>
            <div>
                <label for="to" class="mb-1">Select Date To</label>
                <input type="date" name="to" id="to" class="w-full px-2 py-1 border rounded-md outline-none">
            </div>
            <button class="bg-cyan-600 hover:bg-cyan-500 py-2 px-7 text-white rounded-md" id="filter">View</button>
        </div>
        <div class="max-w-5xl mx-auto mt-10">
            <canvas id="myChart"></canvas>
        </div>
        <table class="w-full text-sm text-left text-gray-500 mt-10 mb-20 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr id="head">
                    <!-- <th scope="col" class="px-6 py-3">
                        Brand
                    </th> -->
                    <!-- <th scope="col" class="px-6 py-3">
                        DKI Jakarta
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jawa Barat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Kalimantan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jawa Tengah
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Bali
                    </th> -->
                </tr>
            </thead>
            <tbody id="list">
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="<?= base_url('select2/js/select2.min.js'); ?>"></script>
    <script type="text/javascript">
        $('.select2').select2({
            placeholder: "---Pilih Area---",
            width: "100%"
        });

        $.ajax({
            url: "<?= base_url('get-area') ?>",
            method: 'get',
            dataType: 'json',
            success: function(data) {
                $('#area').html(`<option value="">--Pilih Area--</option>`)
                for (let index = 0; index < data.data.length; index++) {
                    $('#area').append(`<option value="${data.data[index].area_id}">${data.data[index].area_name}</option>`)
                }
            }
        })

        fetchDataChart()
        fetchDataList()

        $('#filter').click(function() {
            fetchDataChart()
            fetchDataList()
        })

        function fetchDataChart() {
            let dataArea = ''
            for (let index = 0; index < $('#area').val().length; index++) {
                if (index == 0) {
                    dataArea += $('#area').val()[index]
                } else {
                    dataArea += ',' + $('#area').val()[index]
                }
            }

            $.ajax({
                url: '<?= base_url('get-chart'); ?>',
                method: 'GET',
                data: {
                    area: dataArea,
                    from: $('#from').val(),
                    to: $('#to').val(),
                },
                dataType: 'json',
                success: function(data) {
                    updateChart(data);
                },
                error: function(err) {
                    console.error('Gagal mengambil data:', err);
                }
            });
        }

        function fetchDataList() {
            let dataArea = ''
            for (let index = 0; index < $('#area').val().length; index++) {
                if (index == 0) {
                    dataArea += $('#area').val()[index]
                } else {
                    dataArea += ',' + $('#area').val()[index]
                }
            }

            $.ajax({
                url: '<?= base_url('get-list'); ?>',
                method: 'GET',
                data: {
                    area: dataArea,
                    from: $('#from').val(),
                    to: $('#to').val(),
                },
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    $('#list').html(data.html);
                    $('#head').html(`<th scope="col" class="px-6 py-3">Brand</th>`)
                    $('#head').append(data.head)
                },
                error: function(err) {
                    console.error('Gagal mengambil data:', err);
                }
            });
        }

        var ctx = document.getElementById('myChart').getContext('2d');

        function updateChart(data) {

            var label = [];
            var count = [];

            for (let index = 0; index < data.data.length; index++) {
                label.push(data.data[index].area_name);
                count.push(data.data[index].COUNT);
            }

            // console.log(label);
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [{
                        label: 'Percentage (%)',
                        backgroundColor: '#ADD8E6',
                        borderColor: '##93C3D2',
                        data: count
                    }]
                },
            });
        }
    </script>
</body>

</html>