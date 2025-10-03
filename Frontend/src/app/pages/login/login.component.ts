import { Component } from '@angular/core'; 
import { Router, RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-login',
  imports: [FormsModule, RouterModule],
  templateUrl: './login.component.html'
})
export class LoginComponent {
    email: string = '';
    password: string = '';

  constructor(private http: HttpClient, private router:Router, private authService: AuthService) {}

  onSubmit(): void {
    const loginData = {
      email: this.email,
      password: this.password
    };

    const headers = new HttpHeaders({ 'Content-Type': 'application/json' });

    this.http.post<{ token: string }>('http://127.0.0.1:8000/login', loginData, { headers })
    .subscribe({
      next: res => {
        sessionStorage.setItem('token', res.token);
        this.router.navigate(['/permission-access']);
        console.log("Login success", res);
      },
      error: err => {
        console.error("Login failed:", err);
      }
    })
  }
}
