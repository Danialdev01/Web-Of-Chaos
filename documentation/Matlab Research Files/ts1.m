function xt = ts1(xr, w)
    % a la takens space for effective forecast of non-correlated sequences tau=w
    % last point is xr(end) 
    % w - the length of the analog in the time series = dimension
    % tau = 1; % tau=w;
    
    xr = xr(:); % Ensure xr is a column vector
    xt = [];
    
    % Loop over the embedding dimension
    for j = 1:w
        % Extract a slice of the time series with the specified time delay
        xt0 = xr(end - j + 1 : -w : w - j + 1);
        xt = [xt0(end:-1:1) xt];
    end
end



