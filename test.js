
//Creamos un mapa de productos, donde clave es el nombre y valor es la cantidad
let productos = new Map();

fetch('https://fakestoreapi.com/carts')
    .then(res=>res.json())
    .then(json=> {
        json.forEach(carrito => {
            let arrayProductos = carrito.products;
            arrayProductos.forEach(element => {
                if(!productos.get(element.productId)){ //No existe el elemento en el mapa
                    productos.set(element.productId, element.quantity);
                }else{
                    let cantidad = productos.get(element.productId);
                    productos.set(element.productId, cantidad+element.quantity);
                }
            });
        });   

        //Obtenemos 2 mapIterators de claves y valores
        let nombresProductos = productos.keys();
        let valoresProductos = productos.values();

        //Obtenemos la longitud del mapa
        const length = Array.from(nombresProductos).length;
        nombresProductos = productos.keys(); //Actualizamos las claves, ya que con el anterior nos cambia la variable

        //Colocamos los valores
        let valoresSeries = []; //Será un array con objetos {nombre, densidad}
        let i = 0;
        for(const e of valoresProductos){
            let serie = {name:"", data:[].fill(0,0,length)};

            for(j = 0; j<length; j++){
                if(i==j){
                    serie.data.push(e);
                }else{
                    serie.data.push(0);
                }
            }
            
            i++;
            valoresSeries.push(serie);
        }

        //Colocamos los nombres
        i=0;
        for(const nombre of nombresProductos){
            valoresSeries[i++].name = "Producto " + nombre;
        }

        
        //Una vez que hemos filtrado los datos en un Mapa con las densidades de cada productId
        const chart = Highcharts.chart('container', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Productos comprados'
            },
            xAxis: {
                categories: nombresProductos
            },
            yAxis: {
                title: {
                    text: 'Compras'
                }
            },
            series: valoresSeries
        });
    
        }
    
    )