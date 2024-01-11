<script>
    import ApexCharts from 'apexcharts'
</script>
<script type="text/javascript">
    $(() => {
        init()

    })
    init = async () => {
        await loadchartatas();
        await loadchartbawah();
        quick.unblockPage();
    }

    $(document).ready(function() {
        // Check if the user has visited the welcome page before
        const hasVisitedWelcomePage = sessionStorage.getItem('hasVisitedWelcomePage');
        console.log(hasVisitedWelcomePage)
        // If the user hasn't visited the welcome page, show the popup
        if (!hasVisitedWelcomePage) {
            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "warning",
                title: "Generating Cache"
            });
            // var blockfirstpage = '<div class="block">generate cache</div>';
            // $('#pagecontainer').html(blockfirstpage);

            // Set the flag in session storage to indicate that the user has visited the welcome page
            sessionStorage.setItem('hasVisitedWelcomePage', 'true');
        }
    });


    function closeWelcomePopup() {
        $('#welcomePopup').remove();
    }
    loadchartatas = () => {
        var options = {
            series: [{
                name: 'Total Registered Applicants',
                data: [100, 200, 300, 400, 500, 600, 900]
            }],
            chart: {
                height: 350,
                type: 'area'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                type: 'month',
                categories: ["january", "February", "March", "April", "May", "June", "July", "August"]
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#totalapplicants"), options);
        chart.render();
    }
    loadchartbawah = () => {
        var options = {
            series: [{
                name: 'Total Accepted Applicants',
                data: [320, 400, 200]
            }, {
                name: 'Total Rejected Applicants',
                data: [200, 350, 110]
            }],
            chart: {
                type: 'bar',
                height: 400
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['January', 'February', 'March'],
            },
            colors: ["#1B61AD", "#D0D5DD"],
            fill: {
                opacity: 1
            },

        };

        var chart = new ApexCharts(document.querySelector("#totalacc"), options);
        chart.render();

    }
</script>
