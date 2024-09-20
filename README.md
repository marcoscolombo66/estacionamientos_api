**PASOS A SEGUIR PARA PONER EN FUNCIONAMIENTO LA API DE FORMA LOCAL:**

**Clonar repositorio:**
git clone https://github.com/seekerparkingdev/seekerapi.git
git pull

**Cambiar en el .env dentro de seekerapi**
	DB_HOST=seeker-sandbox-mx-mysql  <-- o el nombre del contenedor que tenga el mysql
	De ser necesario ajustar usuario y contraseña
	
**Levantar docker**
docker compose build
docker compose up -d
desde el contenedor con laravel (o desde la ruta /seekerapi)
	composer install
	php artisan migrate

**En linux necesario dar ownership a:**
sudo chown -R www-data:www-data /var/www/seekerapi/storage
sudo chown -R www-data:www-data /var/www/seekerapi/bootstrap/cache

**Generar key para laravel**
php artisan key:generate
**Ir a localhost y ver pantalla de laravel**

**Instalacion y documentacion libreria lomkit: **
https://laravel-rest-api.lomkit.com/

**Instalar mediante lomkit composer** 
composer require lomkit/laravel-rest-api

**Editar en config/rest.php**     
'authorizations' => ['enabled' => false,

**Si no está el archivo api.php en laravel, correr comando:**
php artisan install:api

**Como crear un modelo:**
php artisan make:model Evento

**Como crear un recurso:**
php artisan rest:resource EventoResource

**Setear cuales seran los campos con los cuales se trabajará con la API:**
Ejemplo:
En app/Rest/Resources/EventoResource.php, cambiar public static $model = Evento::class; También fields:

    public function fields(\Lomkit\Rest\Http\Requests\RestRequest $request): array
    {
        return [
            'id',
            'id_empresa',
            'id_venue',
            'nombre',
            'fecha_hora',
            'hora_limite_compra',
            'created_at',
            'updated_at',
        ];
    }
	
**Como crear un cotrolador:**
php artisan rest:controller EventosController

**Setear el recurso en el controlador:**
En app/Rest/Controller/EventosController.php, cambiar public static $resource = EventoResource::class;

**Agregar ruta para la api:**
En routes/api.php agregar:

*use \Lomkit\Rest\Facades\Rest;

Rest::post('Eventos', EventosController::class);*

(Repetir para Venues)

**Definir la relación en el modelo app\Models\Evento:**

	public function venue(): BelongsTo{
        return $this->belongsTo(Venue::class, 'id_venue');
    }
**Definir la relación en el recurso app\Rest\Resources EventoResource:**

    public function relations(RestRequest $request): array
    {
        return [
            BelongsTo::make('venue', VenueResource::class),
        ];
    }
**Generar swagger:**
php artisan rest:documentation-provider

**En bootstrap/providers.php agregar:** App\Providers\RestDocumentationServiceProvider::class

**Requisito para rest:documentation**
php artisan make:factory EventoFactory 

**Genera la documentación en Swagger:**
php artisan rest:documentation 


**Ejemplo de petición:**
*Ruta endpoint producción:* https://api.seekerparking.ar/api/plazas/search
*Ruta Local:* http://localhost/api/plazas/search
Método POST

**Body**:

    {
    	"search": {
    		"filters": [
    		  {
    			"field": "vehiculo.cliente.nombre",
    			"operator": "like",
    			"value": "%%"
    		  },
    		  {
    			"field": "vehiculo.patente",
    			"operator": "like",
    			"value": "%%"
    		  },
    		  {
    			"field": "evento.id",
    			"operator": "=",
    			"value": "212"
    		  }
    		],
        "includes": [
          {
            "relation": "vehiculo.cliente"
          },
          {
            "relation": "evento.eventoEstacionamientoTipoPlaza",
            "filters": [
              {"field": "tipoPlaza.id", "operator": "=", "value": "2"}
            ]
          },
          {
            "relation": "tipoPlaza"
          }
        ]
      }
    }
El **objeto search** representa la búsqueda que se va a realizar, debe incluirse si queremos usar filtros o relaciones. Si el body se deja vacío, trate todos los registros.

**filters** sirve para agregar distintos filtros, en field puede usarse un campo del modelo o el campo de otro modelo a través de una relación.

**Ejemplo:**
 "field": "vehiculo.cliente.nombre", donde vehiculo es una relación definida en el modelo Plaza, cliente es una relación definida en el modelo Vehiculo y nombre es un campo del modelo Cliente.

**Operator:**
    =
    !=
    >
    >=
    <
    <=
    like
    not like
    in
    not in

Y **value** es el valor que debería tener el campo por cual que queremos filtrar la búsqueda.

Se puede usar "**includes**" para que la respuesta a la petición incluya relaciones definidas en el modelo que se está buscando, también se pueden traer relaciones que estén definidas en modelos con los que está relacionado el modelo buscado y aplicar filtros dentro de esas relaciones
**Ejemplo**:
        "includes":
        [
    		{
    		"relation": "vehiculo.cliente"
    		},
    		{
    		"relation": "evento.eventoEstacionamientoTipoPlaza",
    		"filters": [
    		{"field": "tipoPlaza.id", "operator": "=", "value": "2"}
    		]
    		},
    		{
    		"relation": "tipoPlaza"
    		}
        ];


**Donde**:
{"relation": "vehiculo.cliente"}

   "**VEHICULO**" es una relación definida en el modelo Plaza y "**cliente**" es una relación definida en el modelo Vehiculo
    
De igual manera, "**evento**" es una relación definida en el modelo Plaza y "**eventoEstacionamientoTipoPlaza**" es una relación definida en el modelo Evento, solo que en este caso se aplica un filtro en el cual el campo "id" de **tipoPlaza** (que a su vez es una relación definida en el modelo EventoEstacionamientoTipoPlaza) debe ser igual a "2".

Aplicar un **método de autenticación en una API REST en Laravel:**

**Paso a paso para usar Laravel Sanctum:**

1. **Instalar Laravel Sanctum**:
   Ejecuta el siguiente comando en tu terminal para instalar Laravel Sanctum:

   ```bash
   composer require laravel/sanctum
   ```

2. **Publicar la configuración de Sanctum**:
   Publica el archivo de configuración de Sanctum usando el siguiente comando:

   ```bash
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   ```

3. **Ejecutar las migraciones**:
   Ejecuta las migraciones para crear las tablas necesarias para Sanctum:

   ```bash
   php artisan migrate
   ```

4. **Configurar Sanctum**:
   Añade el middleware `Sanctum` en el archivo `config/sanctum.php`:

   ```php
   'middleware' => [
       'api' => [
           \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
           'throttle:api',
           \Illuminate\Routing\Middleware\SubstituteBindings::class,
       ],
   ],
   ```

5. **Añadir el trait `HasApiTokens` en tu modelo de usuario**:
   En el modelo de usuario (`Usuario.php`), añade el trait `HasApiTokens`:

   ```php
   use Laravel\Sanctum\HasApiTokens;

   class Usuario extends Authenticatable
   {
       use HasApiTokens, Notifiable;
       // ...
   }
   ```

6. **Configurar el archivo de autenticación `config/auth.php`**:
   Asegúrate de que la guardia de API esté configurada para usar `sanctum` como el driver:

   ```php
   'guards' => [
       'api' => [
           'driver' => 'sanctum',
           'provider' => 'users',
       ],
   ],
   ```

7. **Crear rutas protegidas**:
   En tu archivo de rutas de API (`routes/api.php`), puedes definir rutas protegidas por Sanctum usando el middleware `auth:sanctum`:

   ```php
   Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
       return $request->user();
   });
   ```

8. **Generar tokens de API**:
   Puedes crear un endpoint de set-tokens para generar tokens. Aquí tienes un ejemplo básico de cómo hacerlo:

   ```php
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Hash;
   use App\Models\User;

   Route::post('set-tokens', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = Usuario::where('email', $request->email)->first();

    if (!$user || md5($request->password) !== $user->password) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $updateToken = $user->createToken('update-token', ['read', 'update']);

    return [
            'update' => $updateToken->plainTextToken
    ];
  });
   ```
  Este endpoint consta de una función que permite generar un token con diferentes habilidades. Para generar tokens se debe enviar en el cuerpo de la solicitud POST, un JSON con email y contraseña del usuario para el cual se desea generar esos tokens:

URL: https://api.seekerparking.ar/api/set-tokens

  {
    "email": "user@mail.com",
    "password": "pass"
  }

9. **Usar el token en las solicitudes**:
   Una vez que el usuario obtenga un token, puede usarlo en las solicitudes a las rutas protegidas añadiéndolo en el encabezado de la solicitud:

   ```http
   Authorization: Bearer <your-token>
   ```

Con estos pasos, habrás configurado una autenticación basada en tokens usando Laravel Sanctum en tu API. Esto permitirá que solo usuarios autenticados puedan acceder a ciertas rutas protegidas.
"# estacionamientos_api" 
