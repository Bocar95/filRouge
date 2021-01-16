import { TestBed } from '@angular/core/testing';

import { ApprenantUserService } from './apprenant-user.service';

describe('ApprenantUserService', () => {
  let service: ApprenantUserService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ApprenantUserService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
