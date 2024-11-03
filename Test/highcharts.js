document.addEventListener('DOMContentLoaded', function () {
    $.get("server.php", function (reservasJSON) {
        
        // Parsear la respuesta JSON si aún no está en formato de objeto
        const data = typeof reservasJSON === "string" ? JSON.parse(reservasJSON) : reservasJSON;

        // Convertir a array de objetos si no es un array
        const chartData = Array.isArray(data) ? data : Object.values(data);

        // Formatear los datos para Highcharts (adaptar a tipo habitación)
        const formattedData = chartData.map(item => ({
            name: item.tipo_habitacion,  // Asumiendo que el campo es "tipo_habitacion"
            y: parseInt(item.total_tipo_hab) // Asumiendo que el campo es "total_tipo_hab"
        }));

        // Crear gráfico de Highcharts
        Highcharts.chart('grafico1', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Reservas por Tipo de Habitación'
            },
            series: [{
                name: 'Reservas',
                colorByPoint: true,
                data: formattedData
            }]
        });
    }).fail(function (xhr, status, error) {
        console.error("Error al obtener los datos: " + error);
    });
});
