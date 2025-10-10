
  //seleccionar los items que vienen por la url
  $(document).ready(function() {
  
      var url = new URL(window.location.href);
      var grupos = url.searchParams.getAll('grupos[]');
      var productos = url.searchParams.getAll('productos[]');
      var vendedores = url.searchParams.getAll('vendedores[]');
      var estados = url.searchParams.getAll('estados[]');
      var municipios = url.searchParams.getAll('municipios[]');
      var clientes = url.searchParams.getAll('clientes[]');
      var frecuencia = url.searchParams.getAll('frecuencia[]');
      var semana = url.searchParams.getAll('semana[]');
      var diavisita = url.searchParams.getAll('diavisita[]');
      
      $('.select-grupos').val(grupos).trigger('change');
      $('.select-productos').val(productos).trigger('change');
      $('.select-vendedores').val(vendedores).trigger('change');
      $('.select-estados').val(estados).trigger('change');
      $('.select-municipios').val(municipios).trigger('change');
      $('.select-clientes').val(clientes).trigger('change');
      $('.select-frecuencia').val(frecuencia).trigger('change');
      $('.select-semana').val(semana).trigger('change');
      $('.select-diavisita').val(diavisita).trigger('change');
  
  });
  
  
  //inicializar libreria select2
  $(document).ready(function() {
      $('.select-grupos').select2();
  });
  
  $(document).ready(function() {
      $('.select-productos').select2();
  });
  
  $(document).ready(function() {
      $('.select-vendedores').select2();
  });
  
  $(document).ready(function() {
      $('.select-estados').select2();
  });
  
  $(document).ready(function() {
      $('.select-municipios').select2();
  });
  
  $(document).ready(function() {
      $('.select-clientes').select2();
  });
  
  $(document).ready(function() {
      $('.select-frecuencia').select2();
  });
  
  $(document).ready(function() {
      $('.select-semana').select2();
  });
  $(document).ready(function() {
      $('.select-diavisita').select2();
  });
  
  
  
  //logiaca para cargar los productos de los grupos seleccionados
  $('#grupos').on('change', function() {
    var gruposSeleccionados = $(this).val();
    // Llama a tu función para obtener los productos de los grupos seleccionados
    obtenerProductos(gruposSeleccionados);
  });
  
  
  //logiaca para cargar los productos de los grupos seleccionados
  $('#estados').on('change', function() {
    var estadosSeleccionados = $(this).val();
  
    // Llama a tu función para obtener los municipiios de los estados seleccionados
    obtenerMunicipios(estadosSeleccionados);
    obtenerClientesEstado(estadosSeleccionados)
  });
  
  
  //logiaca para cargar los clientes de los estados y municipios seleccionados
  $('#municipios').on('change', function() {
    var municipiosSeleccionados = $(this).val();
    // Llama a tu función para obtener los productos de los grupos seleccionados
    obtenerClientesMunicipio(municipiosSeleccionados);
  });
  
  function obtenerProductos(grupos) {
  
    $.ajax({
      url: base_url+'/Mapa/getProductosByGrupos',
      type: 'POST',
      data: { 'grupos': grupos },
      dataType: 'json',
      success: function(data) {
        
        var selectProductos = $('#productos');
        selectProductos.empty(); // Limpiar las opciones existentes
  
        // Agregar una opción vacía al principio
        selectProductos.append($('<option>', { 
          value: '',
          hide : true  
        }));
  
        $.each(data, function(index, producto) {
          selectProductos.append($('<option>', { 
            value: producto.PDT_CODIGO,
            text : producto.PDT_DESCRIPCION 
          }));
        });
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
  }
  
  
  function obtenerMunicipios(estados) {
  
    $.ajax({
      url: base_url+'/Mapa/getMunicipiosByEstado',
      type: 'POST',
      data: { 'estados': estados },
      dataType: 'json',
      success: function(data) {
        var selectMunicipios = $('#municipios');
        selectMunicipios.empty(); // Limpiar las opciones existentes
  
        // Agregar una opción vacía al principio
        /*selectMunicipios.append($('<option>', { 
          value: '',
          hide : true  
        }));*/
  
        $.each(data, function(index, municipio) {
          selectMunicipios.append($('<option>', { 
            value: municipio.MPO_CODIGO,
            text : municipio.MPO_DESCRI
          }));
        });
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
  }
  
  function obtenerClientesEstado(estados) {

  
    $.ajax({
      url: base_url+'/Mapa/getClientesByEstados',
      type: 'POST',
      data: { 'estados': estados },
      dataType: 'json',
      success: function(data) {
        var selectClientes = $('#clientes');
        selectClientes.empty(); // Limpiar las opciones existentes
  
        // Agregar una opción vacía al principio
        selectClientes.append($('<option>', { 
          value: '',
          hide : true  
        }));
  
        $.each(data, function(index, cliente) {
          selectClientes.append($('<option>', { 
            value: cliente.CLT_CODIGO,
            text : cliente.CLT_NOMBRE
          }));
        });
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
  }
  
  function obtenerClientesMunicipio(municipios) {
  
  
    $.ajax({
      url: base_url+'/Mapa/getClientesByMunicipios',
      type: 'POST',
      data: { 'municipios': municipios },
      dataType: 'json',
      success: function(data) {
        var selectClientes = $('#clientes');
        selectClientes.empty(); // Limpiar las opciones existentes
  
        // Agregar una opción vacía al principio
        selectClientes.append($('<option>', { 
          value: '',
          hide : true  
        }));
  
        $.each(data, function(index, cliente) {
          selectClientes.append($('<option>', { 
            value: cliente.CLT_CODIGO,
            text : cliente.CLT_NOMBRE
          }));
        });
      },
      error: function(jqXHR, textStatus, errorThrown) {
      }
    });
  }
    