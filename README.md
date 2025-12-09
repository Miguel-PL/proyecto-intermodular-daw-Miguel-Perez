# proyecto-intermodular-daw-Miguel-Perez
Proyecto Intermodular de 2ºS DAW: Gestión de reservas.
Apartado 1 - Propuesta del proyecto ampliada.
1.1 Título del proyecto
Padel Verde — Sistema de reservas para la gestión de pistas, horarios y reservas de jugadores.
1.2 Objetivo y utilidad
Objetivo: Desarrollar una aplicación web para gestionar reservas de pistas en el club Padel Verde,
permitiendo a los jugadores registrarse, ver disponibilidad, reservar y administrar sus reservas; y
proporcionando a los administradores herramientas para gestionar pistas, usuarios y reservas.
Utilidad: Automatizar la gestión de horarios y reservas para evitar solapamientos y facilitar la
administración y el acceso de los jugadores a su historial y gestión de partidas.
1.3 Requisitos funcionales y reglas del negocio
Roles
• Admin: gestionar pistas (create/read/update/delete), gestionar usuarios (activar/desactivar,
cambiar rol) y ver todas las reservas.
• User: registrarse, editar perfil, crear/cancelar reservas, ver historial.
Configuración inicial definida
• Número de pistas inicial: 3 pistas.
• Horario de funcionamiento: 08:00 — 22:00.
• Duración de reservas: slots de 1 hora; el usuario puede reservar 1 o 2 horas (mínimo 1,5h,
máximo 3h).
• Confirmación de reservas: autoconfirmadas al crearse (no requieren aprobación manual
del admin).
Campo "level" en perfil de usuario
• Se añade el campo level (valor entero) con 5 niveles: 1 a 5.
• Regla de emparejamiento/inscripción: un usuario solo podrá apuntarse (o crear
reservas/jugar) con otros jugadores del mismo nivel o con jugadores de nivel adyacente
(nivel -1 o nivel +1). No se permiten emparejamientos con diferencia de más de 1 nivel.
Esta regla se aplicará en la lógica de creación de reservas y en la interfaz de
búsqueda/filtrado de partidos para asegurar que los jugadores juegan con rivales de
nivel comparable.1.4 Arquitectura y tecnologías
• Frontend: HTML, CSS y JavaScript (cliente). La interfaz será responsive y usará
validaciones en JS.
• Backend: PHP (servidor, XAMPP/WAMP) con endpoint REST o estructura MVC sencilla
según avance.
• Base de datos: MySQL (o MariaDB) con tablas en inglés: users, roles, courts,
reservations.
• Nomenclatura: variables, tablas y comentarios usarán terminología técnica en inglés
cuando proceda (ej.: reservations, court_id, user_level).
• Seguridad básica: hashing de contraseñas (password_hash), validaciones server-side.
