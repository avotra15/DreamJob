import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, tap } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private apiLogin = 'http://127.0.0.1:8000/login';

  constructor(private http: HttpClient) {}

  login(email: string, password: string): Observable<any> {
    return this.http.post<{ token: string }>(this.apiLogin, { email, password}).pipe(
      tap(response => {
        sessionStorage.setItem('token', response.token);
      })
    );
  }
  getToken(): string | null {
  return sessionStorage.getItem('token');
  }

  logout(): void {
    sessionStorage.removeItem('token')
  }
}

