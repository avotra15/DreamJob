import { CommonModule } from '@angular/common';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { Router, RouterModule } from '@angular/router';

@Component({
  selector: 'app-job-single',
  imports: [RouterModule, CommonModule],
  templateUrl: './job-single.component.html'
})
export class JobSingleComponent implements OnInit{
  job: any[]= [];

  constructor(private http:HttpClient, private router: Router) {}

  ngOnInit(): void {
    this.loadjob()
  }

  loadjob():void {
    const token = sessionStorage.getItem('token');

    const headers = new HttpHeaders({ 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` });
    
    this.http.get<any[]>('http://127.0.0.1:8000/api/job/{id}', { headers })
      .subscribe((data) => {
      this.job= data;
    });
  }
}
