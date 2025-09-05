import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'roles-management',
  imports: [CommonModule, FormsModule],
  templateUrl: './roles-management.component.html',
  //styleUrl: './roles-management.component.scss'
})
export class RolesManagementComponent {

  roles: any[] = [];

  constructor(private http:HttpClient, private router:Router) {}

    ngOnInit(): void {
      this.loadRoles();
    }

    loadRoles(): void {
      this.http.get<any[]>('http://127.0.0.1:8000/roles')
        .subscribe({
          next: (data) => {
          this.roles = data;
          },
          error: (err) => {
            console.error("Erreur lors du chargement des rôles:", err);
          }
        });
    }
}
