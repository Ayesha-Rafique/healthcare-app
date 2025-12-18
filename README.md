# Healthcare API - Laravel REST API

A Laravel REST API for managing Patients and Appointments in a healthcare system with proper validation, relationships, and business rules.

 📋 Requirements

- PHP 8.1 or higher
- Composer
- MySQL 8.0 or higher
- Laravel 10.x or 11.x

 📦 Technologies Used

- **Framework**: Laravel 10.x
- **PHP Version**: 8.1+
- **Database**: MySQL 8.0
- **ORM**: Eloquent
- **Validation**: Form Requests

 🚀 Installation & Setup

 1. Clone the Repository
```bash
git clone https://github.com/Ayesha-Rafique/healthcare-app.git
cd healthcare-app
```

 2. Install Dependencies
```bash
composer install
```

 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

 4. Configure Database
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=healthcare_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

 5. Create Database
```bash
mysql -u root -p
CREATE DATABASE healthcare_db;
exit;
```

 6. Run Migrations
```bash
php artisan migrate
```

 7. Start Development Server
```bash
php artisan serve
```

The API will be available at: `http://localhost:8000`

---

 📚 API Endpoints

 Patients

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/patients` | Create a new patient |
| GET | `/api/patients` | List all patients (with search & pagination) |
| GET | `/api/patients/{id}` | Get patient details with latest 5 appointments |

 Appointments

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/appointments` | Create a new appointment |
| GET | `/api/appointments` | List appointments (with filters & pagination) |
| PATCH | `/api/appointments/{id}/status` | Update appointment status |
| DELETE | `/api/appointments/{id}` | Soft delete appointment |

---

 🔍 API Usage Examples

 Create Patient
```bash
curl -X POST http://localhost:8000/api/patients \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "full_name": "Riya Sharma",
    "phone": "9876543210",
    "email": "riya@gmail.com",
    "dob": "2001-02-12"
  }'
```

**Response (201):**
```json
{
  "success": true,
  "message": "Patient created successfully",
  "data": {
    "id": 1,
    "full_name": "Riya Sharma",
    "phone": "9876543210",
    "email": "riya@gmail.com",
    "dob": "2001-02-12"
  }
}
```

 List Patients with Search
```bash
# Search by name or phone
curl -X GET "http://localhost:8000/api/patients?search=Riya&page=1" \
  -H "Accept: application/json"
```

 Get Patient by ID (with latest 5 appointments)
```bash
curl -X GET "http://localhost:8000/api/patients/1" \
  -H "Accept: application/json"
```

 Create Appointment
```bash
curl -X POST http://localhost:8000/api/appointments \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "patient_id": 1,
    "doctor_name": "Dr. Mehta",
    "appointment_date": "2025-12-20",
    "appointment_time": "10:30",
    "notes": "Follow-up visit"
  }'
```

**Response (201):**
```json
{
  "success": true,
  "message": "Appointment created successfully",
  "data": {
    "id": 1,
    "patient_id": 1,
    "doctor_name": "Dr. Mehta",
    "appointment_date": "2025-12-20",
    "appointment_time": "10:30:00",
    "status": "booked",
    "notes": "Follow-up visit"
  }
}
```

 Filter Appointments
```bash
# Filter by status
curl -X GET "http://localhost:8000/api/appointments?status=booked" \
  -H "Accept: application/json"

# Filter by date
curl -X GET "http://localhost:8000/api/appointments?date=2025-12-20" \
  -H "Accept: application/json"

# Filter by both
curl -X GET "http://localhost:8000/api/appointments?date=2025-12-20&status=booked" \
  -H "Accept: application/json"
```

 Update Appointment Status
```bash
curl -X PATCH http://localhost:8000/api/appointments/1/status \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "status": "completed"
  }'
```

 Delete Appointment (Soft Delete)
```bash
curl -X DELETE http://localhost:8000/api/appointments/1 \
  -H "Accept: application/json"
```

---

 ✅ Business Rules Implemented

1. ✅ **No duplicate phone numbers** - Each patient must have a unique phone number
2. ✅ **Email validation and uniqueness** - Valid email format, no duplicates
3. ✅ **No past appointments** - appointment_date must be >= today
4. ✅ **No duplicate appointment slots** - patient_id + date + time must be unique
5. ✅ **Proper HTTP status codes** - 200 (OK), 201 (Created), 404 (Not Found), 422 (Validation Error)
6. ✅ **Comprehensive validation** - Clear error messages for all validation failures
7. ✅ **Soft deletes** - Appointments are soft deleted, not permanently removed
8. ✅ **Pagination** - 15 items per page for list endpoints
9. ✅ **Search functionality** - Search patients by name or phone
10. ✅ **Filter functionality** - Filter appointments by date and/or status

---

 🎯 Features Implemented

 Core Features
- ✅ Patient Management (Create, List, View)
- ✅ Appointment Management (Create, List, Update Status, Delete)
- ✅ Eloquent ORM with proper relationships (Patient hasMany Appointments)
- ✅ Database migrations with constraints and foreign keys
- ✅ Form Request validation classes
- ✅ Soft deletes for appointments
- ✅ Pagination (15 items per page)
- ✅ Search functionality (patients by name/phone)
- ✅ Filter functionality (appointments by date/status)

 Bonus Features ⭐
- ✅ **Form Request classes** for clean validation separation
- ✅ **Soft deletes** implemented for appointments
- ✅ **Latest 5 appointments** included in patient details endpoint
- ✅ **Comprehensive cURL commands** for testing all scenarios
- ✅ **Clean code structure** with proper naming conventions

---

 📝 Testing

 Functional Test Cases Covered

 Patient Creation Tests
```bash
# 1. Valid patient creation (201)
curl -X POST http://localhost:8000/api/patients \
  -H "Content-Type: application/json" -d '{"full_name":"John Doe","phone":"1234567890","email":"john@example.com"}'

# 2. Duplicate phone (422)
curl -X POST http://localhost:8000/api/patients \
  -H "Content-Type: application/json" -d '{"full_name":"Jane Doe","phone":"1234567890","email":"jane@example.com"}'

# 3. Invalid email (422)
curl -X POST http://localhost:8000/api/patients \
  -H "Content-Type: application/json" -d '{"full_name":"Test User","phone":"9999999999","email":"invalid-email"}'

# 4. Missing required fields (422)
curl -X POST http://localhost:8000/api/patients \
  -H "Content-Type: application/json" -d '{"email":"test@example.com"}'
```

 Appointment Tests
```bash
# 5. Valid appointment creation (201)
curl -X POST http://localhost:8000/api/appointments \
  -H "Content-Type: application/json" -d '{"patient_id":1,"doctor_name":"Dr. Smith","appointment_date":"2025-12-25","appointment_time":"10:30"}'

# 6. Past date appointment (422)
curl -X POST http://localhost:8000/api/appointments \
  -H "Content-Type: application/json" -d '{"patient_id":1,"doctor_name":"Dr. Smith","appointment_date":"2024-01-01","appointment_time":"10:30"}'

# 7. Duplicate slot (422)
curl -X POST http://localhost:8000/api/appointments \
  -H "Content-Type: application/json" -d '{"patient_id":1,"doctor_name":"Dr. Jones","appointment_date":"2025-12-25","appointment_time":"10:30"}'

# 8. Invalid status update (422)
curl -X PATCH http://localhost:8000/api/appointments/1/status \
  -H "Content-Type: application/json" -d '{"status":"invalid_status"}'

# 9. Valid status update (200)
curl -X PATCH http://localhost:8000/api/appointments/1/status \
  -H "Content-Type: application/json" -d '{"status":"completed"}'
```

 Search & Filter Tests
```bash
# 10. Search patients by name
curl -X GET "http://localhost:8000/api/patients?search=John"

# 11. Search patients by phone
curl -X GET "http://localhost:8000/api/patients?search=1234567890"

# 12. Filter appointments by status
curl -X GET "http://localhost:8000/api/appointments?status=booked"

# 13. Filter appointments by date
curl -X GET "http://localhost:8000/api/appointments?date=2025-12-25"
```

 Error Handling Tests
```bash
# 14. Patient not found (404)
curl -X GET "http://localhost:8000/api/patients/999"

# 15. Appointment not found (404)
curl -X DELETE "http://localhost:8000/api/appointments/999"
```

---

 🛡️ Security Features

- ✅ **Mass assignment protection** using `$fillable` in models
- ✅ **Form Request validation** prevents invalid data
- ✅ **SQL injection prevention** via Eloquent ORM
- ✅ **Unique constraints** at database level
- ✅ **Type casting** for dates and times
- ✅ **Input sanitization** through Laravel validation

---

 ⏱️ Development Information

**Time Taken**: Approximately 3 hours

**Laravel Version**: 10.x  
**PHP Version**: 8.1+  
**Database**: MySQL 8.0


 📧 Contact

For any questions or clarifications about this project:

**Email**: ayesha.rafique403@gmail.com  
**GitHub**: [Ayesha-Rafique](https://github.com/Ayesha-Rafique)


**Note**: This README provides comprehensive documentation for setting up, running, and testing the Healthcare API. All endpoints have been tested and validated against the assignment requirements.