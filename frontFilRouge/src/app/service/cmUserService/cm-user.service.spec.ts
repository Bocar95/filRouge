import { TestBed } from '@angular/core/testing';

import { CmUserService } from './cm-user.service';

describe('CmUserService', () => {
  let service: CmUserService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CmUserService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
