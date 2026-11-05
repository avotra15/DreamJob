import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterModule } from '@angular/router';

@Component({
  selector: 'app-registrer',
  imports: [FormsModule, RouterModule, CommonModule],
  templateUrl: './registrer.component.html',
})
export class RegistrerComponent implements OnInit {
  nm: string = '';
  mail: string = '';
  rls: string = 'ROLE_USER';
  mdp: string = '';
  errorMessage: string = '';

  rolesList: any[] = [];

  constructor(private http: HttpClient, private router: Router) {}

  ngOnInit(): void {
    this.loadRoles();
  }

  loadRoles(): void {
    this.http.get<any[]>('http://127.0.0.1:8000/roles').subscribe({
      next: (data) => (this.rolesList = data),
      error: (err) => console.error('Erreur lors du chargement des rôles:', err),
    });
  }

  onSubmit(): void {
    this.errorMessage = '';

    if (!this.rls) {
      this.errorMessage = 'Veuillez choisir un rôle.';
      return;
    }

    const registrerData = {
      Nom: this.nm.trim(),
      Email: this.mail.trim().toLowerCase(),
      Roles: [this.rls],
      Password: this.mdp,
    };

    this.http.post('http://127.0.0.1:8000/api/register', registrerData).subscribe({
      next: (res) => {
        console.log('Registrer success', res);
        this.router.navigate(['/login']);
      },
      error: (err) => {
        console.error('Status:', err.status, 'Body:', err.error);
        this.errorMessage = err.error?.error ?? 'Une erreur est survenue.';
      },
    });
  }
}