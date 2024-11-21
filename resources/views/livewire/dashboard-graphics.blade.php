<div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const veterinarianData = @json($appointmentsByVeterinarian); // Datos desde Livewire
    
            const vetLabels = veterinarianData.map(item => item.name); // Nombres de veterinarios
            const vetTotals = veterinarianData.map(item => item.total); // Totales de citas
    
            const ctx = document.getElementById('appointmentsByVeterinarianChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar', // Tipo de gráfica
                data: {
                    labels: vetLabels, // Nombres en el eje X
                    datasets: [{
                        label: 'Citas',
                        data: vetTotals, // Totales en el eje Y
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
                    }
                }
            });
        });
    </script>
  <script>
    // Script para el gráfico de Citas por Semana
    document.addEventListener("DOMContentLoaded", function () {
        const weekData = @json($appointmentsByWeek); // Datos desde Livewire

        const weekLabels = weekData.map(item => item.week); // Semanas
        const weekTotals = weekData.map(item => item.total); // Totales de citas

        const ctx2 = document.getElementById('appointmentsByWeekChart').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: weekLabels,
                datasets: [{
                    label: 'Citas por Semana',
                    data: weekTotals,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Datos desde Livewire para Citas por Mes
            const monthData = @json($appointmentsByMonth); // Datos desde el backend
            const monthLabels = monthData.map(item => item.month); // Meses (e.g., "Enero 2024")
            const monthTotals = monthData.map(item => item.total); // Totales de citas por mes

            const ctx3 = document.getElementById('appointmentsByMonthChart').getContext('2d');
            new Chart(ctx3, {
                type: 'bar', // Tipo de gráfica
                data: {
                    labels: monthLabels, // Meses como etiquetas en el eje X
                    datasets: [{
                        label: 'Citas por Mes', // Etiqueta del dataset
                        data: monthTotals, // Datos (totales de citas por mes)
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo de las barras
                        borderColor: 'rgba(54, 162, 235, 1)', // Color del borde de las barras
                        borderWidth: 1 // Ancho del borde
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true // Comienza el eje Y en cero
                        }
                    }
                }
            });
        });
    </script>

<script>
    // Script para el gráfico de Citas por Estado
    document.addEventListener("DOMContentLoaded", function () {
        const statusData = @json($appointmentsByStatus); // Datos desde Livewire

        const statusLabels = statusData.map(item => item.status); // Estados
        const statusTotals = statusData.map(item => item.total); // Totales de citas

        const ctx3 = document.getElementById('appointmentsByStatusChart').getContext('2d');
        new Chart(ctx3, {
            type: 'pie', // Gráfico de torta
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusTotals,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)', // Rojo
                        'rgba(54, 162, 235, 0.2)', // Azul
                        'rgba(255, 206, 86, 0.2)', // Amarillo
                        'rgba(75, 192, 192, 0.2)', // Verde
                        'rgba(153, 102, 255, 0.2)', // Morado
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
            }
        });
    });
</script>
<script>
    // Script para el gráfico de Métodos de Pago
    document.addEventListener("DOMContentLoaded", function () {
        const paymentData = @json($appointmentsByPaymentMethod); // Datos desde Livewire

        const paymentLabels = paymentData.map(item => item.method); // Métodos de pago
        const paymentTotals = paymentData.map(item => item.total); // Totales de citas

        const ctx4 = document.getElementById('appointmentsByPaymentChart').getContext('2d');
        new Chart(ctx4, {
            type: 'pie', // Gráfico de pastel
            data: {
                labels: paymentLabels,
                datasets: [{
                    data: paymentTotals,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)', // Rojo
                        'rgba(54, 162, 235, 0.2)', // Azul
                        'rgba(255, 206, 86, 0.2)', // Amarillo
                        'rgba(75, 192, 192, 0.2)', // Verde
                        'rgba(153, 102, 255, 0.2)', // Morado
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const hourData = @json($appointmentsByHour); // Datos desde Livewire

        const hourLabels = hourData.map(item => `${item.hour}:00`); // Horas con formato "HH:00"
        const hourTotals = hourData.map(item => item.total); // Totales de citas

        // Asignar colores por hora (puedes personalizar más colores)
        const hourColors = hourLabels.map((_, index) => {
            const baseColor = (index * 40) % 360; // Cálculo de color dinámico
            return `hsla(${baseColor}, 70%, 50%, 0.6)`; // Formato HSL con transparencia
        });

        // Configuración inicial del gráfico
        const ctx3 = document.getElementById('appointmentsByHourChart').getContext('2d');
        const chart = new Chart(ctx3, {
            type: 'bar', // Gráfico de barras
            data: {
                labels: hourLabels,
                datasets: [{
                    label: 'Citas por Hora',
                    data: hourTotals,
                    backgroundColor: hourColors,
                    borderColor: hourColors.map(color => color.replace('0.6', '1')), // Bordes sin transparencia
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Crear filtros de horas dinámicamente
        const hourFiltersDiv = document.getElementById('hour-filters');
        hourLabels.forEach((hour, index) => {
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.checked = true;
            checkbox.id = `filter-hour-${index}`;
            checkbox.value = index;

            const label = document.createElement('label');
            label.htmlFor = `filter-hour-${index}`;
            label.innerText = hour;
            label.className = 'ml-2 mr-4';

            hourFiltersDiv.appendChild(checkbox);
            hourFiltersDiv.appendChild(label);
        });

        // Actualizar el gráfico y la diferencia al filtrar horas
        document.getElementById('hour-filters').addEventListener('change', () => {
            const selectedHours = [];
            const selectedTotals = [];
            const selectedColors = [];

            hourLabels.forEach((hour, index) => {
                const checkbox = document.getElementById(`filter-hour-${index}`);
                if (checkbox.checked) {
                    selectedHours.push(hour);
                    selectedTotals.push(hourTotals[index]);
                    selectedColors.push(hourColors[index]);
                }
            });

            // Actualizar los datos del gráfico
            chart.data.labels = selectedHours;
            chart.data.datasets[0].data = selectedTotals;
            chart.data.datasets[0].backgroundColor = selectedColors;
            chart.update();

            // Calcular y mostrar la diferencia entre la hora con más y menos citas
            const maxCitas = Math.max(...selectedTotals);
            const minCitas = Math.min(...selectedTotals);
            const differenceText = `Diferencia entre la hora con más citas (${maxCitas}) y menos citas (${minCitas}): ${maxCitas - minCitas}`;
            document.getElementById('hour-difference-info').innerText = differenceText;
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dayOfWeekData = @json($appointmentsByDayOfWeek); // Datos desde Livewire

        const dayLabels = dayOfWeekData.map(item => item.day); // Nombres de los días
        const dayTotals = dayOfWeekData.map(item => item.total); // Totales de citas

        // Asignar colores específicos a cada día
        const dayColors = {
            'Lunes': 'rgba(75, 192, 192, 0.6)',
            'Martes': 'rgba(153, 102, 255, 0.6)',
            'Miércoles': 'rgba(255, 205, 86, 0.6)',
            'Jueves': 'rgba(201, 203, 207, 0.6)',
            'Viernes': 'rgba(54, 162, 235, 0.6)',
            'Sábado': 'rgba(255, 99, 132, 0.6)',
            'Domingo': 'rgba(255, 159, 64, 0.6)'
        };

        const backgroundColors = dayLabels.map(day => dayColors[day] || 'rgba(0, 0, 0, 0.6)');
        const borderColors = backgroundColors.map(color => color.replace('0.6', '1'));

        // Configuración inicial del gráfico
        const ctx4 = document.getElementById('appointmentsByDayOfWeekChart').getContext('2d');
        const chart = new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: dayLabels,
                datasets: [{
                    label: 'Citas por Día',
                    data: dayTotals,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Crear filtros de días dinámicamente
        const dayFiltersDiv = document.getElementById('day-filters');
        dayLabels.forEach((day, index) => {
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.checked = true;
            checkbox.id = `filter-${day}`;
            checkbox.value = index;

            const label = document.createElement('label');
            label.htmlFor = `filter-${day}`;
            label.innerText = day;
            label.className = 'ml-2 mr-4';

            dayFiltersDiv.appendChild(checkbox);
            dayFiltersDiv.appendChild(label);
        });

        // Actualizar el gráfico y la diferencia al filtrar días
        document.getElementById('day-filters').addEventListener('change', () => {
            const selectedDays = [];
            const selectedTotals = [];
            const selectedColors = [];

            dayLabels.forEach((day, index) => {
                const checkbox = document.getElementById(`filter-${day}`);
                if (checkbox.checked) {
                    selectedDays.push(day);
                    selectedTotals.push(dayTotals[index]);
                    selectedColors.push(backgroundColors[index]);
                }
            });

            // Actualizar los datos del gráfico
            chart.data.labels = selectedDays;
            chart.data.datasets[0].data = selectedTotals;
            chart.data.datasets[0].backgroundColor = selectedColors;
            chart.update();

            // Calcular y mostrar la diferencia entre el día con más y menos citas
            const maxCitas = Math.max(...selectedTotals);
            const minCitas = Math.min(...selectedTotals);
            const differenceText = `Diferencia entre el día con más citas (${maxCitas}) y menos citas (${minCitas}): ${maxCitas - minCitas}`;
            document.getElementById('difference-info').innerText = differenceText;
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const activeUsersData = @json($activeUsersData); // Datos desde Livewire

        const labels = activeUsersData.map(item => item.status); // Activos / Inactivos
        const totals = activeUsersData.map(item => item.total); // Totales

        const colors = ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'];
        const borderColors = ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'];

        const ctx = document.getElementById('activeUsersChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie', // Gráfico de torta
            data: {
                labels: labels,
                datasets: [{
                    label: 'Usuarios',
                    data: totals,
                    backgroundColor: colors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                const value = context.raw;
                                const percentage = ((value / total) * 100).toFixed(2);
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const speciesData = @json($animalsBySpecies); // Datos desde Livewire

        const labels = speciesData.map(item => item.species); // Especies
        const totals = speciesData.map(item => item.total); // Totales por especie

        const colors = labels.map(() => `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.2)`);
        const borderColors = labels.map(() => `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`);

        const ctx = document.getElementById('animalsBySpeciesChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut', // Gráfico de dona
            data: {
                labels: labels,
                datasets: [{
                    label: 'Animales por Especie',
                    data: totals,
                    backgroundColor: colors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                const value = context.raw;
                                const percentage = ((value / total) * 100).toFixed(2);
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

 <script>
        document.addEventListener("DOMContentLoaded", function () {
            let chartInstance; // Para actualizar el gráfico dinámicamente

            const renderChart = (revenueData) => {
                const labels = revenueData.map(item => item.period); // Periodos
                const totals = revenueData.map(item => item.total); // Totales

                const ctx = document.getElementById('revenueByPeriodChart').getContext('2d');
                if (chartInstance) chartInstance.destroy(); // Destruir gráfico anterior si existe
                chartInstance = new Chart(ctx, {
                    type: 'line', // Gráfico de líneas
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Ingresos',
                            data: totals,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Ingresos ($)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Periodo'
                                }
                            }
                        }
                    }
                });
            };

            // Escuchar actualizaciones desde Livewire
            Livewire.on('updateChart', renderChart);
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let chartInstance;

        const renderChart = (revenueData) => {
            const labels = revenueData.map(item => item.period); // Períodos
            const totals = revenueData.map(item => item.total); // Totales

            const ctx = document.getElementById('invoiceRevenueChart').getContext('2d');
            if (chartInstance) chartInstance.destroy(); // Destruir gráfico previo si existe
            chartInstance = new Chart(ctx, {
                type: 'bar', // Gráfico de barras
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ingresos ($)',
                        data: totals,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Ingresos ($)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Periodo'
                            }
                        }
                    }
                }
            });
        };

        // Escuchar actualizaciones desde Livewire
        Livewire.on('updateInvoiceRevenueChart', renderChart);
    });
</script>

    <div class="chart-container">
        <h1 class="text-xl font-bold mb-2">Citas por Veterinario</h1>
        <canvas id="appointmentsByVeterinarianChart"></canvas>
    </div>
    <div class="chart-container">
        <h1 class="text-xl font-bold mb-2">Citas por Semana</h1>
        <canvas id="appointmentsByWeekChart"></canvas>
    </div>
    <div class="chart-container">
        <h1 class="text-xl font-bold mb-2">Citas por Mes</h1>
        <canvas id="appointmentsByMonthChart"></canvas>
    </div>
    <div class="chart-container">
        <h1 class="text-xl font-bold mb-2">Citas por Estado</h1>
        <canvas id="appointmentsByStatusChart"></canvas>
    </div>
    <div class="chart-container">
        <h1 class="text-xl font-bold mb-2">Métodos de Pago</h1>
        <canvas id="appointmentsByPaymentChart"></canvas>
    </div>
    <div class="chart-container">
        <h1 class="text-xl font-bold mb-2">Citas por Hora</h1>
        <canvas id="appointmentsByHourChart"></canvas>
    </div>
    <div class="chart-container">
        <h1 class="text-xl font-bold mb-2">Citas por Día</h1>
        <canvas id="appointmentsByDayOfWeekChart"></canvas>
    </div>
    <div class="chart-container">
        <h1 class="text-xl font-bold mb-2">Usuarios Activos vs Inactivos</h1>
        <canvas id="activeUsersChart"></canvas>
    </div>
    <div class="chart-container">
        <h1 class="text-xl font-bold mb-2">Cantidad de Animales por Especie</h1>
        <canvas id="animalsBySpeciesChart"></canvas>
    </div>
</div>