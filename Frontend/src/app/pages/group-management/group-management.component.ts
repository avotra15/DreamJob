import { CommonModule } from '@angular/common';
import { HttpClient, HttpHeaders } from '@angular/common/http';
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
    selectedRole: string = ''; 

    constructor(private http:HttpClient, private router:Router) {}

    ngOnInit(): void {
      this.loadUsers();
    }

    loadUsers(): void {
      this.http.get<any>('http://127.0.0.1:8000/users')
        .subscribe({
          next: (res) => {
            this.users = res.data ?? [];
          },
          error: (err) => {
            console.error('Erreur lors du chargement des users:', err);
            this.users = [];
          }
        });
    }

    onSubmit(id:number): void {
      const headers = new HttpHeaders({ 'Content-Type': 'application/json' });

      this.http.get<any>(`http://127.0.0.1:8000/user/${id}`, { headers })
              .subscribe({
              next: res => {
                console.log(res);
                this.selectedRole = res.role;
                this.router.navigate(['/roles-management/user', id]);
              },
              error: err => {
                console.error("Diriger failed:", err);
      }
    });
  }

  onSubmit2(): void {
    this.router.navigate(['/registrer']);
  }
}
