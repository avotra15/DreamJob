import { TestBed } from '@angular/core/testing';
import {
  ActivatedRouteSnapshot,
  CanActivateFn,
  Router,
  RouterStateSnapshot,
  UrlTree,
} from '@angular/router';

import { authGuard } from './services/auth.service.spec';
import { AuthService } from './services/auth.service';



describe('authGuard', () => {
  let authServiceMock: { getToken: jasmine.Spy };
  let routerMock: { createUrlTree: jasmine.Spy };

  const executeGuard: CanActivateFn = (...guardParameters) =>
    TestBed.runInInjectionContext(() => authGuard(...guardParameters));

  const route = {} as ActivatedRouteSnapshot;
  const state = {} as RouterStateSnapshot;

  beforeEach(() => {
    authServiceMock = { getToken: jasmine.createSpy('getToken') };
    routerMock = { createUrlTree: jasmine.createSpy('createUrlTree') };

    TestBed.configureTestingModule({
      providers: [
        { provide: AuthService, useValue: authServiceMock },
        { provide: Router, useValue: routerMock },
      ],
    });
  });

  it('should be created', () => {
    expect(executeGuard).toBeTruthy();
  });

  it('should allow access when a token exists', () => {
    authServiceMock.getToken.and.returnValue('fake-token');

    const result = executeGuard(route, state);

    expect(result).toBeTrue();
    expect(routerMock.createUrlTree).not.toHaveBeenCalled();
  });

  it('should redirect to /login when there is no token', () => {
    const fakeUrlTree = {} as UrlTree;
    authServiceMock.getToken.and.returnValue(null);
    routerMock.createUrlTree.and.returnValue(fakeUrlTree);

    const result = executeGuard(route, state);

    expect(result).toBe(fakeUrlTree);
    expect(routerMock.createUrlTree).toHaveBeenCalledWith(['/login']);
  });
});