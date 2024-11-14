// Inicializamos el mapa de productos
let productos = new Map();

fetch('https://fakestoreapi.com/carts')
    .then(res => res.json())
    .then(json => {
        json.forEach(carrito => {
            let arrayProductos = carrito.products;
            arrayProductos.forEach(element => {
                if (!productos.get(element.productId)) { // No existe el elemento en el mapa
                    productos.set(element.productId, element.quantity);
                } else {
                    let cantidad = productos.get(element.productId);
                    productos.set(element.productId, cantidad + element.quantity);
                }
            });
        });

        // Obtenemos las claves y valores del mapa de productos
        let nombresProductos = productos.keys();
        let valoresProductos = productos.values();
        const length = Array.from(nombresProductos).length;
        nombresProductos = productos.keys(); // Actualizamos las claves

        let total = 0;
        for (const e of valoresProductos) {
            total += e;
        }

        valoresProductos = productos.values(); // Reiniciamos para otra iteración
        let valoresSeries = [];
        let i = 0;
        for (const e of valoresProductos) {
            let serie = { name: "", y: 0 };
            for (let j = 0; j < length; j++) {
                if (i === j) {
                    serie.y = ((e / total) * 100);
                }
            }
            i++;
            valoresSeries.push(serie);
        }

        i = 0;
        for (const v of nombresProductos) {
            valoresSeries[i++].name = "Producto " + v;
        }

        // Generamos la gráfica de productos
        Highcharts.chart('container', {
            chart: { type: 'pie' },
            title: { text: 'Porcentaje de ventas en artículos' },
            tooltip: { valueSuffix: '%' },
            subtitle: {
                text: 'Source: <a href="https://fakestoreapi.com/" target="_default">Fake Store Api</a>'
            },
            series: [{
                name: 'Percentage',
                colorByPoint: true,
                data: valoresSeries
            }]
        });
    });

$(document).ready(function () {
    $.get("Test/server.php", function (data) {
        console.log("Datos recibidos:", data);
  
        const nacionalidadData = data.nacionalidad.map(item => ({
          name: item.Nacionalidad,
          y: parseInt(item.TotalPedidos)
        }));
  
        const ciudadData = data.ciudad.map(item => ({
          name: item.Ciudad,
          y: parseInt(item.TotalPedidos)
        }));
  
        // Generar gráfico para nacionalidad
        Highcharts.chart('grafico1', {
          chart: { type: 'pie' },
          title: { text: 'Pedidos por nacionalidad' },
          series: [{
            name: 'Naciones',
            colorByPoint: true,
            data: nacionalidadData
          }]
        });
  
        // Generar gráfico para ciudad
        Highcharts.chart('grafico2', {
          chart: { type: 'pie' },
          title: { text: 'Pedidos por ciudad' },
          series: [{
            name: 'Ciudades',
            colorByPoint: true,
            data: ciudadData
          }]
        });
      }).fail(function (xhr, status, error) {
        console.error("Error al obtener los datos: " + error);
      });
});
