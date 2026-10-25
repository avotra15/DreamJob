import { CommonModule } from '@angular/common';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterModule } from '@angular/router';

@Component({
  selector: 'app-registrer',
  imports: [FormsModule, RouterModule, CommonModule],
  templateUrl: './registrer.component.html',
})
export class RegistrerComponent {
    nm: string = '';
    mail: string = '';
    rls: string = '';
    mdp: string = '';

    rolesList: any[] = [];

    constructor(private http:HttpClient, private router:Router) {}

    ngOnInit(): void {
      this.loadRoles();
    }

    loadRoles(): void {
      this.http.get<any[]>('http://127.0.0.1:8000/roles')
        .subscribe({
          next: (data) => {
          this.rolesList = data;
          },
          error: (err) => {
            console.error("Erreur lors du chargement des rôles:", err);
          }
        });
    }

    onSubmit(): void {
      const token = sessionStorage.getItem('token');

      const registrerData = {
              Nom: this.nm,
              Email: this.mail,
              Roles: [this.rls],
              Password: this.mdp
      };

      const headers = new HttpHeaders({ 'Content-Type': 'application/json' });

           this.http.post('http://127.0.0.1:8000/api/register', registrerData, { headers })
              .subscribe({
              next: res => {
                console.log("Registrer success", res);
              },
              error: err => {
                console.error("Registrer failed:", err);
      }
    })
    }
}
