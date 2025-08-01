import { CommonModule } from '@angular/common';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { Router, RouterModule } from '@angular/router';

@Component({
  selector: 'app-users',
  imports: [RouterModule, CommonModule],
  templateUrl: './users-component.component.html'
})
export class UsersComponentComponent implements OnInit {
  usersList: any[]= [];

  constructor(private http:HttpClient, private router: Router) {}

  ngOnInit(): void{
    this.loadUsers()
  }

  loadUsers(): void {
    const token = sessionStorage.getItem('token');

    const headers = new HttpHeaders({ 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` });
    
    this.http.get<any[]>('http://127.0.0.1:8000/api/users', { headers })
      .subscribe((data) => {
      this.usersList= data;
    });
  }

  onDelete(id: number): void {
      if (confirm('Supprimer cet utilisateur ?')) {
      const token = sessionStorage.getItem('token');

      const headers = new HttpHeaders({ 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` });

      this.http.delete<any[]>(`http://127.0.0.1:8000/api/delete/${id}`, { headers })
        .subscribe({
        next: () => {
          this.loadUsers();
        },
        error: (error) => {
          console.error('Erreur lors de la suppression:', error);
          alert('Suppression impossible.');
        }
      });
      }
    }

  onEdit(id: number): void {
  this.router.navigate(['/edit', id]);
}

}
