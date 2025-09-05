import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterModule } from '@angular/router';

@Component({
  selector: 'group-management',
  imports: [CommonModule, RouterModule, FormsModule],
  templateUrl: './group-management.component.html'
})
export class GroupManagementComponent {
    users: any[] = [];

    constructor(private http:HttpClient, private router:Router) {}

    ngOnInit(): void {
      this.loadRoles();
    }

    loadRoles(): void {
      this.http.get<any[]>('http://127.0.0.1:8000/api/users')
        .subscribe({
          next: (data) => {
          this.users = data;
          },
          error: (err) => {
            console.error("Erreur lors du chargement des users:", err);
          }
        });
    }
}
