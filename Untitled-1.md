eBike-Rental-System/
├── app/                     # Aquí vive toda la lógica del sistema
│   ├── config/              # Configuración de base de datos y rutas
│   ├── controllers/         # Lógica intermedia (AuthController, BikeController, etc.)
│   ├── models/              # Conexión a la BD y consultas (User, Bike, Rental)
│   ├── views/               # Pantallas (HTML/PHP) divididas en layouts, admin y user
│   ├── helpers/             # Utilidades (validaciones, sesión, generación de QR)
│   └── middleware/          # Filtros de seguridad (autenticación, roles)
├── public/                  # La única carpeta accesible directamente por el navegador
│   ├── assets/              # Archivos CSS, JavaScript (Bootstrap, Mapbox) e imágenes
│   ├── uploads/             # Archivos subidos por los usuarios
│   └── index.php            # Punto de entrada de toda la aplicación
├── tests/                   # Pruebas unitarias, de integración y end-to-end
├── docs/                    # Documentación, manuales y diagramas C4/ER
├── scripts/                 # Scripts (aquí puedes guardar tu ebike_modelo.sql)
├── composer.json            # Gestor de dependencias de PHP
└── README.md                # Presentación del proyecto para GitHub